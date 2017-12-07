<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

use Dhtmlx\Connector\SchedulerConnector;

class Calendar extends Back {

    public function index() {
        $output = new stdClass();
        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $this->load->model('Client_model');
        $client_model = new Client_model();
        $output->clients = $client_model->get_clients_by_uid($this->oc_auth->get_user_id());

        $this->load->model('Resource_model');
        $resource_model = new Resource_model();
        $output->resources = $resource_model->get_resources_by_uid($this->oc_auth->get_user_id());
		
		


        $this->load->model('Sms_model');
        $sms_model = new Sms_model();

        $output->sms_setting = $sms_model->get_sms_notification_setting_by_user($this->oc_auth->get_user_id());

        $layout = new Layout();
        $layout->set_title("Agenda");
        $layout->view("sections/calendar", $output, 'calendar_page');
    }

    public function resource() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('resource');
        $crud->set_subject('Ressource &agrave; assigner aux rendez-vous');
        $crud->required_fields('name');
        $crud->where('user = "' . $this->oc_auth->get_user_id() . '"');
        $crud->columns('name', 'is_default');
        $crud->callback_before_insert(array($this, '_callback_set_default_resource'));
        $crud->callback_before_update(array($this, '_callback_set_default_resource'));

        $crud->display_as(array(
            'name' => 'Nom ressource',
            'is_default' => 'Ressource par d&eacute;faut'
        ));

        $crud->field_type('user', 'hidden', $this->oc_auth->get_user_id());
        $crud->field_type('is_default', 'true_false', array("non", "oui"));

        $user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }

        $state = $crud->getState();

        $output = $crud->render();

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        if ($state == 'read') {
            $output->view_mode = true;
        }

        $layout = new Layout();
        $layout->set_title("Ressources");
        $layout->view("sections/calendar_resource", $output, 'user_page');
    }

    function _callback_set_default_resource($post_array) {
        if ($post_array['is_default']) {
            $this->load->model('Resource_model');
            $resource_model = new Resource_model();
            $resource_model->unset_default();
        }
        return true;
    }

}
