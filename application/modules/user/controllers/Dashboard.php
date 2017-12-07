<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Dashboard extends Back {

    public function index() {
        $output = new stdClass();
        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $layout = new Layout();
        $layout->set_title("Dashboard");
        $layout->view("sections/dashboard", $output, 'user_page');
    }

    public function profile() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('oc_users');
        $crud->set_subject('Profil');
        $crud->set_relation('role_id', 'user_roles', 'name');
        $crud->set_relation('couleur_fond', 'color', 'color_name');
        $crud->set_relation_n_n('nom_type', 'user_doc', 'type_doc', 'users', 'typ_doc_id', 'nom_type');
        $crud->set_field_upload('photo_use', 'assets/uploads/profile');
        $crud->columns('photo_use', 'uid', 'displayname', 'email_adress', 'nom_type', 
		'nom_societe',
		'adresse',
		'code_postal',
		'ville',
		'pays',
		'nom_banque',
		'iban',
		'swift',
		'siren',
		'n_tva',
		
		
		'is_crm', 'is_sms', 'use_excel');
        $crud->fields('photo_use', 'uid', 'displayname', 'email_adress', 'couleur_fond',
		'nom_societe',
		'adresse',
		'code_postal',
		'ville',
		'pays',
		'nom_banque',
		'iban',
		'swift',
		'siren',
		'n_tva'
		
		);
        $crud->where('uid', $this->oc_auth->get_user_id());

        $crud->field_type('is_crm', 'true_false');
        $crud->field_type('is_sms', 'true_false');
        $crud->field_type('use_excel', 'true_false');

        $user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }

        $crud->unset_add();
        $crud->unset_delete();

        $crud->display_as(array(
            'photo_use' => 'Avatar',
            'uid' => 'Login',
            'email_adress' => 'Adresse email',
            'displayname' => 'Nom complet',
            'groupes' => 'Groupe',
            'use_excel' => 'Export Excel',
            'is_crm' => 'Acc&eacute;s au CRM',
            'is_sms' => 'Acc&eacute;s aux SMS',
            'nom_type' => 'Type de document',
            'couleur_fond' => 'Background',
			'nom_societe' => 'Societe',
			'adresse' => 'Adresse',
			'code_postal' => 'CP',
			'ville' => 'Ville',
			'pays' => 'Pays',
			'nom_banque' => 'Banque',
			'iban' => 'IBAN',
			'swift' => 'SWIFT',
			'siren'=> 'SIREN/SIRET',
			'n_tva'=> 'TVA'
        ));

        $output = $crud->render();

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $layout = new Layout();
        $layout->set_title("Mon profil");
        $layout->view("sections/profile", $output, 'user_page');
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

                if (isset($this->_alertes) && !empty($this->_alertes)) {
                    $output->alertes = $this->_alertes;
                }
                if (isset($this->_user) && !empty($this->_user)) {
                    $output->user = $this->_user;
                }

                $layout = new Layout();
                $layout->set_title("Mot de passe");
                $layout->view("sections/password", $output, 'user_page');
            }
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function not_allowed() {
        $layout = new Layout();
        $layout->set_title("Acc&egrave;s restreint");
        $layout->view("sections/restricted", null, 'user_page');
    }

}
