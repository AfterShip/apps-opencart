<?php
class ControllerModuleDaTrackShipment extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('module/da_track_shipment');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('da_track_shipment', $this->request->post);
            $this->updateCouriers(); //update the couriers in the db

            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));

        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['entry_key'] = $this->language->get('entry_key');
        $this->data['entry_username'] = $this->language->get('entry_username');

        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_courier'] = $this->language->get('entry_courier');
        $this->data['text_courier_priority'] =$this->language->get('text_courier_priority');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_module'] = $this->language->get('button_add_module');
        $this->data['button_remove'] = $this->language->get('button_remove');
        $this->data['button_refresh'] = $this->language->get('button_refresh');


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['key'])) {
            $this->data['error_key'] = $this->error['key'];
        } else {
            $this->data['error_key'] = '';
        }

        if (isset($this->error['username'])) {
            $this->data['error_username'] = $this->error['username'];
        } else {
            $this->data['error_username'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/da_track_shipment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/da_track_shipment', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['da_track_shipment_after_ship_key'])) {
            $this->data['da_track_shipment_after_ship_key'] = $this->request->post['da_track_shipment_after_ship_key'];
        } else {
            $this->data['da_track_shipment_after_ship_key'] = $this->config->get('da_track_shipment_after_ship_key');
        }
        //new for the username
        if (isset($this->request->post['da_track_shipment_after_ship_username'])) {
            $this->data['da_track_shipment_after_ship_username'] = $this->request->post['da_track_shipment_after_ship_username'];
        } else {
            $this->data['da_track_shipment_after_ship_username'] = $this->config->get('da_track_shipment_after_ship_username');
        }

        if (isset($this->request->post['da_track_shipment_status'])) {
            $this->data['da_track_shipment_status'] = $this->request->post['da_track_shipment_status'];
        } else {
            $this->data['da_track_shipment_status'] = $this->config->get('da_track_shipment_status');
        }

        $couriers = $this->getCouriers();
        $this->data['couriers'] = $couriers;
        // $da_track_shipment_courier_status = array();
        //
        // for ($i = 0; $i < count($couriers); $i++) {
        //     $courier_status = $this->config->get('da_track_shipment_courier_status_' . $couriers[$i]["courier_id"]);
        //     $da_track_shipment_courier_status[$couriers[$i]["courier_id"]] = $courier_status;
        // }
        //
        // $this->data["da_track_shipment_courier_status"] = $da_track_shipment_courier_status;

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'module/da_track_shipment.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/da_track_shipment')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['da_track_shipment_status']) {
            if ($this->request->post['da_track_shipment_after_ship_key'] != "") {
                $result = $this->validateKey($this->request->post['da_track_shipment_after_ship_key']);
                if ($result != 1) {
                    $this->error['key'] = $result;
                }
            }
        }

        if ($this->request->post['da_track_shipment_status']) {
            $username = $this->request->post['da_track_shipment_after_ship_username'];

            if ($username == "" || !preg_match("/^[a-z0-9]+$/", $username)) {
                if($username == ""){
                     $this->error['username'] = $this->language->get('error_username');
                }else{
                     $this->error['username'] = $this->language->get('error_username_invalid');
                }
            }
        }

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
    private function updateCouriers(){
            $couriers = $this->getAftershipCouriers();
            if($couriers){
                $this->deleteCouriers();
                $this->insertCouriers($couriers);
            }
    }

    private function getAftershipCouriers(){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.aftership.com/v4/couriers');

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'aftership-api-key: ' . $this->request->post['da_track_shipment_after_ship_key'] . '',
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
    private function deleteCouriers(){
        $q = "TRUNCATE TABLE `da_courier`";
        $this->db->query($q);
    }

    /**
    * insert the new couriers of the db
    */
    private function insertCouriers($json_couriers){

        $query = "INSERT INTO `da_courier` (`slug`, `name`, `web_url`) VALUES";
    //    -- (1, "ups", "UPS", "http://www.ups.com"),'

        foreach ($json_couriers as $courier){

            $query .=  " (\"". $courier["slug"] . "\",\"". $courier["name"] . "\",\"". $courier["web_url"] . "\"),";
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
        //some system user do not allow this
        //set_time_limit(0);

        //add two new columns to the database
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order_history` LIKE 'tracking_number'");

        if ($query->num_rows) {
            //already exist one version of aftership.

            $query2 = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order_history` LIKE 'courier_id'");

            if ($query2->num_rows) {
                //exist one version previous to this one, so we have to update the tables

                //first add a column name slug

                $query_add_slug = "ALTER TABLE `" . DB_PREFIX . "order_history`  ADD `slug` varchar(255) NOT NULL DEFAULT '',  ADD INDEX (`slug`)";
                $this->db->query($query_add_slug);

                //populate the slug column
                $query_populate_slug = "UPDATE `". DB_PREFIX . "order_history` AS oh, `da_courier` AS da SET oh.`slug` = da.`slug` WHERE da.`courier_id` = oh.`courier_id` AND oh.`courier_id` > 0";
                $this->db->query($query_populate_slug);

                //delete the column id_courier
                $query_delete_column = "ALTER TABLE `" . DB_PREFIX . "order_history` DROP COLUMN `courier_id`";
                $this->db->query($query_delete_column);

            }

        } else {
            $query_string = "ALTER TABLE `" . DB_PREFIX . "order_history`  ADD `slug` varchar(255) NOT NULL DEFAULT '',  ADD `tracking_number` VARCHAR(255) NOT NULL,  ADD INDEX (`slug`), ADD INDEX (  `tracking_number` )";

            $this->db->query($query_string);
        }

        $query_drop = "DROP TABLE IF EXISTS `da_courier`";
        $this->db->query($query_drop);
        $query_create_couriers = "CREATE TABLE IF NOT EXISTS `da_courier` (`courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,`slug` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`web_url` varchar(255) NOT NULL,PRIMARY KEY (`courier_id`),UNIQUE KEY `slug` (`slug`),KEY `name` (`name`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
        $this->db->query($query_create_couriers);
    }

    /**
     * Remove any configured webhook from the MailChimp system
     * when the module is uninstalled.
     */
    public function uninstall()
    {

        // //delete the table da_courier
        // $query_drop =  "DROP TABLE IF EXISTS `da_courier`";
        // $this->db->query($query_drop);

        // //delete the columns slug and tracking_number of order_history
        // $query_drop_columns = "ALTER TABLE `" . DB_PREFIX . "order_history` DROP COLUMN `slug`, DROP COLUMN `tracking_number`";
        // $this->db->query($query_drop_columns);

    }


    private function SplitSQL($file, $delimiter = ';')
    {


        $output = array();

        if (is_file($file) === true) {
            $file = fopen($file, 'r');

            if (is_resource($file) === true) {
                $query = array();

                while (feof($file) === false) {
                    $query[] = fgets($file);

                    if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                        $query = trim(implode('', $query));

                        $output[] = $query;

                    }

                    if (is_string($query) === true) {
                        $query = array();
                    }
                }

                return $output;
            }
        }

        return false;
    }

    public function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }
}

?>
