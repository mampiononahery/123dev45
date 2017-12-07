<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Object extends Back {

    public function index() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud->set_theme('flexigrid');
                $crud->set_table('client_objects');
                $crud->set_subject('Objet client');
                $crud->columns('object_name', 'active', 'last_update');
                
                $crud->unset_fields('last_update');
                
                $crud->display_as(array(
                    'object_name' => 'Nom objet',
                    'last_update' => 'Date modification',
                    'active' => 'Activ&eacute;'));

                $output = $crud->render();

                $layout = new Layout();
                $layout->set_title("Gestion des objets client");
                $layout->view("sections/object", $output, 'admin_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function option() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud->set_theme('flexigrid');
                $crud->set_table('client_options');
                $crud->set_subject('Option champ client');
                $crud->columns('option_value');

                $crud->display_as(array('option_value' => 'Option'));

                $output = $crud->render();

                $layout = new Layout();
                $layout->set_title("Gestion des options champs client");
                $layout->view("sections/field", $output, 'admin_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}
