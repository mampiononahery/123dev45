<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Color extends Back {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('color');

        $crud->display_as(array(
            'color_name' => 'Nom',
            'color_code' => 'Code'
        ));

        $output = $crud->render();

        $layout = new Layout();
        $layout->set_title("Gestion des couleurs");
        $layout->view("sections/color", $output, 'admin_page');
    }

}
