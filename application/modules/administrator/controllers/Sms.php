<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Sms extends Back {

    public function index() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud = new grocery_CRUD();
                $crud->set_theme('flexigrid');
                $crud->set_table('marketing_sms_logs');
                $crud->set_relation('rdv_id', 'rdv', '{nom_client} {dt_start}');
                $crud->set_relation('request_id', 'marketing_request', 'request_name');
                $crud->columns('sending_type', 'total_sent', 'total_error', 'phone_number', 'message', 'sending_date');
                $crud->set_subject('Statistiques');

                $crud->display_as(array(
                    'rdv_id' => 'Rendez-vous',
                    'sending_type' => 'Type d\'envoi',
                    'total_sent' => 'Qt&eacute;s envoy&eacute;s',
                    'total_error' => 'Qt&eacute;s en erreur',
                    'phone_number' => 'N. t&eacute;l&eacute;phone',
                    'sending_date' => 'Date d\'envoi'
                ));

                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_delete();

                $output = $crud->render();

                $layout = new Layout();
                $layout->set_title("SMS");
                $layout->view("sections/sms", $output, 'admin_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function test() {
        $this->load->library('api_sms');
        $api_sms = new Api_sms();
        $api_sms->set_destination_number('0033661322520');
        $api_sms->set_sms('test envoi');
        $api_sms->send_sms();
    }

    public function test_multiple() {
        $this->load->library('api_sms');
        $api_sms = new Api_sms();
        $numbers = array('0033661322522', '0033661322520');
        $api_sms->set_destination_number($numbers);
        $api_sms->set_sms('test envoi 3');
        $api_sms->send_multiple_sms();
    }

}
