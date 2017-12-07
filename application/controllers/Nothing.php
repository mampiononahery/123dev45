<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'controllers/Front.php');

class Nothing extends Front {

    public function found() {
        $layout = new Layout();
        $layout->set_title("Page not found");
        $layout->view("sections/nothing", null, 'front_page');
    }

}
