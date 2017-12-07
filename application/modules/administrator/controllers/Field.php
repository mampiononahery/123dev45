<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Field extends Back {

    public function index() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud->set_theme('flexigrid');
                $crud->set_table('client_fields');
                $crud->set_subject('Champ entit&eacute; client');
                $crud->set_relation_n_n('options', 'client_field_options', 'client_options', 'field_id', 'option_id', 'option_value');
                $crud->required_fields('field_id', 'label', 'field_type');
                $crud->columns('label', 'field_type', 'options');

                $crud->display_as(array(
                    'label' => 'Nom champ',
                    'field_type' => 'Type du champ'));

                $output = $crud->render();

                $layout = new Layout();
                $layout->set_title("Gestion des champs entit&eacute; client");
                $layout->view("sections/field", $output, 'admin_page');
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
    
     public function object() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud->set_theme('flexigrid');
                $crud->set_table('client_object_fields');
                $crud->set_subject('Champ object');
                $crud->set_relation('object_id', 'client_objects', 'object_name');
                $crud->set_relation_n_n('options', 'client_object_field_options', 'client_options', 'field_id', 'option_id', 'option_value');
                $crud->required_fields('object_id', 'field_id', 'label', 'field_type');
                $crud->columns('object_id', 'label', 'field_type');

                $crud->display_as(array(
                    'object_id' => 'Objet',
                    'label' => 'Nom champ',
                    'field_type' => 'Type du champ'));

                $output = $crud->render();

                $layout = new Layout();
                $layout->set_title("Gestion des champs objet client");
                $layout->view("sections/field", $output, 'admin_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}
