<?php

class ControllerExtensionModuleDaTrackShipment extends Controller
{

    private $error = array();

    public function index()
    {

        $this->load->language('extension/module/da_track_shipment');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_da_track_shipment', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->updateCouriers(); //update the couriers in the db
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['entry_key'] = $this->language->get('entry_key');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_courier'] = $this->language->get('entry_courier');
        $data['text_courier_priority'] = $this->language->get('text_courier_priority');
        $data['text_get_key'] = $this->language->get('text_get_key');
        $data['text_get_username'] = $this->language->get('text_get_username');
        $data['text_refresh'] = $this->language->get('text_refresh');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_refresh'] = $this->language->get('button_refresh');


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['key'])) {
            $data['error_key'] = $this->error['key'];
        } else {
            $data['error_key'] = '';
        }

        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/da_track_shipment', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );
        $data['action'] = $this->url->link('extension/module/da_track_shipment', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);


        if (isset($this->request->post['module_da_track_shipment_after_ship_key'])) {
            $data['module_da_track_shipment_after_ship_key'] = $this->request->post['module_da_track_shipment_after_ship_key'];
        } else {
            $data['module_da_track_shipment_after_ship_key'] = $this->config->get('module_da_track_shipment_after_ship_key');
        }
        //new for the username
        if (isset($this->request->post['module_da_track_shipment_after_ship_username'])) {
            $data['module_da_track_shipment_after_ship_username'] = $this->request->post['module_da_track_shipment_after_ship_username'];
        } else {
            $data['module_da_track_shipment_after_ship_username'] = $this->config->get('module_da_track_shipment_after_ship_username');
        }

        if (isset($this->request->post['module_da_track_shipment_status'])) {
            $data['module_da_track_shipment_status'] = $this->request->post['module_da_track_shipment_status'];
        } else {
            $data['module_da_track_shipment_status'] = $this->config->get('module_da_track_shipment_status');
        }

        $couriers = $this->getCouriers();
        $data['couriers'] = $couriers;
        // $da_track_shipment_courier_status = array();
        //
        // for ($i = 0; $i < count($couriers); $i++) {
        //     $courier_status = $this->config->get('da_track_shipment_courier_status_' . $couriers[$i]["courier_id"]);
        //     $da_track_shipment_courier_status[$couriers[$i]["courier_id"]] = $courier_status;
        // }
        //
        // $data["da_track_shipment_courier_status"] = $da_track_shipment_courier_status;

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('extension/module/da_track_shipment', $data));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/da_track_shipment')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['module_da_track_shipment_status']) {
            if ($this->request->post['module_da_track_shipment_after_ship_key'] != "") {
                $result = $this->validateKey($this->request->post['module_da_track_shipment_after_ship_key']);
                if ($result != 1) {
                    $this->error['key'] = $result;
                }
            }else {
                $this->error['key'] =  $this->language->get('error_key_invalid');
            }
        }


        if ($this->request->post['module_da_track_shipment_status']) {
            $username = $this->request->post['module_da_track_shipment_after_ship_username'];

            if ($username == "" || !preg_match("/^[a-z0-9]+$/", $username)) {
                if ($username == "") {
                    $this->error['username'] = $this->language->get('error_username');
                } else {
                    $this->error['username'] = $this->language->get('error_username_invalid');
                }
            }
        }

//        return !$this->error;

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }


    private function validateKey($key)
    {

        if (stristr($key, ':') === FALSE) {
            // only one key is used, run the key here
            $result = $this->validateKeyCurl($key);
            if ($result === true) {
                return $result;
            } else {
                return $this->language->get('error_key_invalid');
            }
        } else {
            // multi key is found

            $keys = explode(",", $key);

            for ($i = 0; $i < sizeof($keys); $i++) {
                $each_key = explode(":", $keys[$i]);
                $result = $this->validateKeyCurl($each_key[1]);
                if ($result === true) {
                    return $result;
                } else {
                    return 'Store ID: ' . $each_key[0] . ': Error Key: ' . $this->language->get('error_key_invalid');
                }
            }

        }
    }


    private function validateKeyCurl($key)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.aftership.com/v4');

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'aftership-api-key: ' . $key . '',
            'Content-Type: application/json'
        ));

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        $content = curl_exec($curl);
        curl_close($curl);

        $content = json_decode($content, true);

        if (isset($content["meta"]["code"])) {
            if ($content["meta"]["code"] === 200)
                return true;
        } else {
            return false;
        }

    }


    private function getCouriers()
    {
        $q = "SELECT * FROM `da_courier`";

        $couriers = array();

        $query = $this->db->query($q);

        foreach ($query->rows as $result) {

            $couriers[] = $result;
        }

        return $couriers;
    }

    /**
     * Make a call for get the user couriers
     */
    private function updateCouriers()
    {
        $couriers = $this->getAftershipCouriers();
        if ($couriers) {
            $this->deleteCouriers();
            $this->insertCouriers($couriers);
        }
    }

    private function getAftershipCouriers()
    {

        $api_key = $this->request->post['module_da_track_shipment_after_ship_key'];

        if (stristr($api_key, ':') !== FALSE) {
            $keys = explode(",", $api_key);
            $each_key = explode(":", $keys[0]);
            $api_key = $each_key[1];
            // only one key is used, the first one
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.aftership.com/v4/couriers');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'aftership-api-key: ' . $api_key . '',
            'Content-Type: application/json'
        ));

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        $content = curl_exec($curl);
        curl_close($curl);
        $content = json_decode($content, true);
        if (isset($content["meta"]["code"])) {
            if ($content["meta"]["code"] === 200)
                return $content["data"]["couriers"];
        } else {
            return false;
        }
    }

    /**
     * Delete the couriers of the db
     */
    private function deleteCouriers()
    {
        $query = $this->db->query("SHOW COLUMNS FROM `da_courier` LIKE 'required_fields'");
        if ($query->num_rows > 0) {
            $q = "TRUNCATE TABLE `da_courier`";
            $this->db->query($q);
        } else {
            $query_drop = "DROP TABLE IF EXISTS `da_courier`";
            $this->db->query($query_drop);
            $query_create_couriers = "CREATE TABLE IF NOT EXISTS `da_courier` (`courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,`slug` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`required_fields` varchar(255),`web_url` varchar(255) NOT NULL,PRIMARY KEY (`courier_id`),UNIQUE KEY `slug` (`slug`),KEY `name` (`name`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
            $this->db->query($query_create_couriers);
        }
    }

    /**
     * insert the new couriers of the db
     */
    private function insertCouriers($json_couriers)
    {

        $query = "INSERT INTO `da_courier` (`slug`, `name`, `required_fields`, `web_url`) VALUES";
        //    -- (1, "ups", "UPS", "http://www.ups.com"),'

        foreach ($json_couriers as $courier) {
            $required_fields_list = array();
            $required_fields = '';
            if (sizeof($courier["required_fields"]) > 0) {
                foreach ($courier["required_fields"] as $field) {
                    $required_fields_list[] = $field;
                }
                $required_fields = implode(', ', $required_fields_list);
            }
            $query .= " (\"" . $courier["slug"] . "\",\"" . $courier["name"] . "\",\"" . $required_fields . "\",\"" . $courier["web_url"] . "\"),";
        }

        $query = trim($query, ","); //remove trailing commas
        $query .= ";";
        $this->db->query($query);

    }


    /**
     * Set default values for the modules when it is installed
     * by the OpenCart system.
     */
    public function install()
    {
        $this->load->language('extension/module/da_track_shipment');
        //add two new columns to the database
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order_history` LIKE 'tracking_number'");
        $this->debug_to_console($query->num_rows);

        if ($query->num_rows) {
            //already exist one version of aftership.

            $query2 = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order_history` LIKE 'courier_id'");

            if ($query2->num_rows) {
                //exist one version previous to this one, so we have to update the tables

                //first add a column name slug

                $query_add_slug = "ALTER TABLE `" . DB_PREFIX . "order_history`  ADD `slug` varchar(255) NOT NULL DEFAULT ''";
                $result_query = $this->db->query($query_add_slug);

                if ($result_query) {
                    //populate the slug column
                    $query_populate_slug = "UPDATE `" . DB_PREFIX . "order_history` AS oh, `da_courier` AS da SET oh.`slug` = da.`slug` WHERE da.`courier_id` = oh.`courier_id` AND oh.`courier_id` > 0";
                    $result_query1 = $this->db->query($query_populate_slug);

                    if ($result_query1) {
                        //delete the column id_courier
                        $query_delete_column = "ALTER TABLE `" . DB_PREFIX . "order_history` DROP COLUMN `courier_id`";
                        $result_query2 = $this->db->query($query_delete_column);

                        if ($result_query2) {
                            $query_drop = "DROP TABLE IF EXISTS `da_courier`";
                            $this->db->query($query_drop);
                            $query_create_couriers = "CREATE TABLE IF NOT EXISTS `da_courier` (`courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,`slug` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`required_fields` varchar(255),`web_url` varchar(255) NOT NULL,PRIMARY KEY (`courier_id`),UNIQUE KEY `slug` (`slug`),KEY `name` (`name`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
                            $this->db->query($query_create_couriers);
                        } else {

                            $this->session->data['error'] = $this->language->get('error_db1');
                        }
                    } else {
                        $this->session->data['error'] = $this->language->get('error_db2');
                    }
                } else {
                    $this->session->data['error'] = $this->language->get('error_db3');
                }

            } else {
                $this->session->data['error'] = $this->language->get('error_db4');
            }

        } else {
            //installation from 0, add 2 columns and create database da_couriers
            $query_string = "ALTER TABLE `" . DB_PREFIX . "order_history`  ADD `slug` varchar(255) NOT NULL DEFAULT '',  ADD `tracking_number` VARCHAR(255) NOT NULL DEFAULT ''";

            $this->db->query($query_string);
            $query_drop = "DROP TABLE IF EXISTS `da_courier`";
            $this->db->query($query_drop);
            $query_create_couriers = "CREATE TABLE IF NOT EXISTS `da_courier` (`courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,`slug` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`required_fields` varchar(255),`web_url` varchar(255) NOT NULL,PRIMARY KEY (`courier_id`),UNIQUE KEY `slug` (`slug`),KEY `name` (`name`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
            $this->db->query($query_create_couriers);
        }


    }

    public function uninstall()
    {

        $sql = "TRUNCATE TABLE `da_courier`";
        $this->db->query($sql);

    }

    public function debug_to_console($data)
    {

        if (is_array($data))
            $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }

}

?>
