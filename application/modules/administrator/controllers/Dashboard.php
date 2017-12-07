<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Dashboard extends Back {

    public function index() {
        $layout = new Layout();
        $layout->set_title("Dashboard");
        $layout->view("sections/dashboard", null, 'admin_page');
    }

    public function profile() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('oc_users');
        $crud->set_subject('Profil');
        $crud->set_relation('role_id', 'user_roles', 'name');
        $crud->set_relation('couleur_fond', 'color', 'color_name');
        $crud->set_relation_n_n('nom_type', 'user_doc', 'type_doc', 'users', 'typ_doc_id', 'nom_type', null, 'field_type = "text"');
        $crud->set_field_upload('photo_use', 'assets/uploads/profile');
        $crud->columns('photo_use', 'uid', 'displayname', 'email_adress', 'groupes', 'nom_type', 'is_crm', 'is_sms', 'use_excel');
        $crud->fields('photo_use', 'uid', 'displayname', 'email_adress', 'groupes', 'couleur_fond', 'nom_type', 'is_crm', 'is_sms', 'use_excel');
        $crud->where('uid', $this->oc_auth->get_user_id());

        $crud->unset_fields('password', 'role_id');
        $crud->unset_add();
        $crud->unset_delete();

        $crud->display_as(array(
            'photo_use' => 'Avatar',
            'uid' => 'Identifiant',
            'email_adress' => 'Adresse email',
            'displayname' => 'Nom complet',
            'groupes' => 'Groupe',
            'use_excel' => 'Export Excel',
            'is_crm' => 'Acc&eacute;s au CRM',
            'is_sms' => 'Acc&eacute;s aux SMS',
            'nom_type' => 'Type de document',
            'couleur_fond' => 'Background'
        ));

        $output = $crud->render();

        $layout = new Layout();
        $layout->set_title("Mon profil");
        $layout->view("sections/profile", $output, 'admin_page');
    }
	
    public function password() {
        try {
            $crud = new grocery_CRUD();
            $user_id = $this->oc_auth->get_user_id();
            if (!empty($user_id)) {
                $crud->set_theme('flexigrid');
                $crud->set_table('oc_users');
                $crud->set_subject('Mot de passe');
                $crud->where('uid', $user_id);
                $crud->required_fields('username');
                $crud->fields('uid', 'password', 'new_password', 'verify_password');
                $crud->columns('uid', 'displayname', 'email_adress');
                $crud->unset_add();
                $crud->unset_read();
                $crud->unset_delete();

                $crud->field_type('password', 'hidden');
                $crud->change_field_type('new_password', 'password');
                $crud->change_field_type('verify_password', 'password');
                $crud->set_rules('verify_password', 'Verify Password', 'trim|required');
                $crud->callback_before_insert(array($this, 'password_generator'));
                $crud->callback_before_update(array($this, 'password_generator'));

                $crud->display_as(array(
                    'uid' => 'Identifiant',
                    'displayname' => 'Nom',
                    'email_adress' => 'Email',
                    'password' => 'Mot de passe',
                    'new_password' => 'Nouveau mot de passe',
                    'verify_password' => 'Confirmez votre mot de passe'));

                $output = $crud->render();
		

                $layout = new Layout();
				
                $layout->set_title("Mot de passe");
				
				
                $layout->view("sections/password", $output, 'admin_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}
