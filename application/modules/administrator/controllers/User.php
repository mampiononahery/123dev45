<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class User extends Back {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('oc_users');
        $crud->set_relation('role_id', 'user_roles', 'name');
        $crud->set_relation('couleur_fond', 'color', 'color_name');
        $crud->set_relation_n_n('nom_type', 'user_doc', 'type_doc', 'users', 'typ_doc_id', 'nom_type');
        $crud->set_relation_n_n('client_fields', 'client_fields_filter', 'client_fields', 'uid', 'field_id', '{client_fields.field_id} - {label}');
        $crud->set_field_upload('photo_use', 'assets/uploads/profile');
        $crud->required_fields('uid', 'displayname', 'email_adress');
        $crud->unset_fields('password');

       $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_read();

        $crud->field_type('is_crm', 'true_false');
        $crud->field_type('is_sms', 'true_false');
        $crud->field_type('use_excel', 'true_false');

        $crud->columns('photo_use', 'uid', 'displayname', 'email_adress', 'nom_type', 'is_crm', 'is_sms', 'use_excel');
        $crud->fields('photo_use', 'uid', 'displayname', 'email_adress', 'couleur_fond', 'nom_type', 'client_fields', 'is_crm', 'is_sms', 'use_excel');
        $crud->display_as(array(
            'photo_use' => 'Avatar',
            'uid' => 'Login',
			
            'email_adress' => 'Adresse email',
            'displayname' => 'Nom complet',
            'nom_type' => 'Type de document',
            'client_fields' => 'Champs clients',
            'use_excel' => 'Export Excel',
            'is_crm' => 'Acc&eacute;s au CRM',
            'is_sms' => 'Acc&eacute;s aux SMS',
            'couleur_fond' => 'Background'
        ));

        $output = $crud->render();

        $layout = new Layout();
        $layout->set_title("Utilisateur");
        $layout->view("sections/user", $output, 'admin_page');
    }

}
