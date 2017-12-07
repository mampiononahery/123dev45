<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('layout');
        $this->load->model('User_model');
		 $this->load->library('oc_auth');
    }

}
