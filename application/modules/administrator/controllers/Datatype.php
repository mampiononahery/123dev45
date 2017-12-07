<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Datatype extends Back {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('type_doc');

        $output = $crud->render();

        $layout = new Layout();
        $layout->set_title("Types de document");
        $layout->view("sections/datatype", $output, 'admin_page');
    }

}
