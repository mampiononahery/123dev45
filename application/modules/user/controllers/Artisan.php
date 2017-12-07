<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Artisan extends Back {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('artisan');
        $crud->set_subject('Artisan');

        $crud->columns('artisan');
        $crud->field_type('user', 'hidden', $this->oc_auth->get_user_id());

        $user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }

        $output = $crud->render();

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }
        
        $layout = new Layout();
        $layout->set_title("Artisan");
        $layout->view("sections/artisan", $output, 'user_page');
    }

}
