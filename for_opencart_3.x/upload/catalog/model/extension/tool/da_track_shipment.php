<?php
class ModelExtensionToolDaTrackShipment extends Model
{
	public function getEnabledCouriers() {
		$q = "SELECT * FROM `da_courier` ORDER BY `name` ASC";

		$couriers = array();

		$query = $this->db->query($q);

		foreach ($query->rows as $result) {
				$couriers[] = $result;
		}

		return $couriers;
	}

	public function sendTrackingNumber($tracking_number, $slug, $store_id = 0, $order_id, $comment) {
		$store_key = '';

		if ($this->config->get('module_da_track_shipment_after_ship_key') == "") {
			return 'NO_KEY';
		} else {
			if (stristr($this->config->get('module_da_track_shipment_after_ship_key'), ':') === FALSE) {
				// only one key is used, run the key here
				$store_key = $this->config->get('module_da_track_shipment_after_ship_key');
			} else {
				// multi key is found
				$keys = explode(",", $this->config->get('module_da_track_shipment_after_ship_key'));

				for ($i = 0; $i < sizeof($keys); $i++) {
					$each_key = explode(":", $keys[$i]);
					if ($each_key[0] == $store_id) {
						$store_key = $each_key[1];
						break;
					}
				}
			}
		}

		if ($store_key != '') {

			$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

			$q = "SELECT `iso_code_3` FROM `" . DB_PREFIX . "country` WHERE `country_id` = '" . $order_query->row["shipping_country_id"] . "'";
			$r = $this->db->query($q);
			if ($r->num_rows != 0) {
				$country_iso_3 = $r->row["iso_code_3"];
			} else {
				$country_iso_3 = "";
			}

			$required_fields = array();
			$courier_query = $this->db->query("SELECT * FROM `da_courier` WHERE slug = '" . $slug . "'");
			if ($courier_query->row['required_fields']) {
				$required_fields = explode(",", $courier_query->row['required_fields']);
			}

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product op WHERE op.order_id = '" . (int)$order_id . "'");

			$item_names_list = array();
			if ($product_query->num_rows != 0) {
				foreach ($product_query->rows as $p) {
					$item_names_list[] = $p['name'] . ' x ' . $p['quantity'];
				}
			}
			$item_names = implode(', ', $item_names_list);

			$tracking_numbers = explode(",", $tracking_number);

			$returns = array();

			for ($i = 0; $i < count($tracking_numbers); $i++) {

				$fields = explode(":", $tracking_numbers[$i]);

				$request = array();
				$request['tracking'] = array();
				$request['tracking']['tracking_number'] = trim($fields[0]);
				$request['tracking']['slug'] = $slug;
				$request['tracking']['tracking_postal_code'] = $order_query->row['shipping_postcode'];
				$request['tracking']['tracking_ship_date'] = date("Ymd");
				$request['tracking']['tracking_destination_country'] = $country_iso_3;
				$request['tracking']['title'] = 'Order ID: ' . $order_id;
				$request['tracking']['order_id'] = $order_id;
				$request['tracking']['order_id_path'] = '';
				$request['tracking']['customer_name'] = $order_query->row['firstname'] . ' ' . $order_query->row['lastname'];
				$request['tracking']['emails'] = array($order_query->row['email']);
				$request['tracking']['smses'] = array($order_query->row["telephone"]);
				$request['tracking']['destination_country_iso3'] = $country_iso_3;
				$request['tracking']['custom_fields'] = array();
				$request['tracking']['custom_fields']['note'] = $comment;
				$request['tracking']['custom_fields']['source'] = 'opencart';
				$request['tracking']['custom_fields']['item_names'] = $item_names;

				for($j = 0; $j < count($required_fields); $j++) {
					if (count($fields) > $j+1) {
						if (trim($required_fields[$j]) == 'tracking_ship_date') {
							$fields[$j+1] = date("Ymd", strtotime($fields[$j+1]));
						}
						$request['tracking'][trim($required_fields[$j])] = $fields[$j+1];
					}
					else {
						if ($request['tracking'][trim($required_fields[$j])]) {
							array_push($fields, $request['tracking'][trim($required_fields[$j])]);
						}
					}
				}

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://api.aftership.com/v4/trackings');
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'aftership-api-key: ' . $store_key . '',
					'Content-Type: application/json',
				));

				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_SSLVERSION, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

				$content = curl_exec($curl);
				curl_close($curl);

				$tracks = $tracking_numbers[$i];
				if (count($fields) > 1) {
					$tracks = implode(':', $fields);
				}

				$returns[] = array('tracking_number' => trim($tracks), 'result' => json_decode($content, true));
			}

			return $returns;
		} else {
			return 'NO_KEY';
		}
	}
}

?>
