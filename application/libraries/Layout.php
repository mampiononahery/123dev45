<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Layout {

    // Will hold a CodeIgniter instance 
    private $CI;
    // Will hold a title for the page, NULL by default 
    private $title_for_layout = NULL;
    // The title separator, ' | ' by default 
    private $title_separator = ' PowerCRM | ';

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function set_title($title) {
        $this->title_for_layout = $title;
    }
	public function view_html($view_name, $params = array(), $layout = 'front_page') {
		// Handle the site's title. If NULL, don't add anything. If not, add a  
        // separator and append the title. 
        if ($this->title_for_layout !== NULL) {
            $separated_title_for_layout = $this->title_separator . $this->title_for_layout;
        }
        // Load the view's content, with the params passed 
        $view_content = $this->CI->load->view($view_name, $params, TRUE);
		return $view_content;
        // Now load the layout, and pass the view we just rendered 
        $view_layout = $this->CI->load->view('layouts/' . $layout, array(
            'content_for_layout' => $view_content,
            'title_for_layout' => $separated_title_for_layout
        ),true);
		
		return $view_layout;
	 
	}
    public function view($view_name, $params = array(), $layout = 'front_page') {
        // Handle the site's title. If NULL, don't add anything. If not, add a  
        // separator and append the title. 
        if ($this->title_for_layout !== NULL) {
            $separated_title_for_layout = $this->title_separator . $this->title_for_layout;
        }
        // Load the view's content, with the params passed 
        $view_content = $this->CI->load->view($view_name, $params, TRUE);

        // Now load the layout, and pass the view we just rendered 
        $this->CI->load->view('layouts/' . $layout, array(
            'content_for_layout' => $view_content,
            'title_for_layout' => $separated_title_for_layout
        ));
    }

}
