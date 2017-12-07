<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Front.php');

class Auth extends Front {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('oc_auth');
        $this->lang->load('oc_auth');
        $this->load->model('User_model');
    }

    function index() {
        if ($message = $this->session->flashdata('message')) {
            $this->load->view('auth/general_message', array('message' => $message));
        } else {
            redirect('/auth/login/');
        }
    }

    /**
     * Login user on the site
     *
     * @return void
     */
    function login() {
        if ($this->oc_auth->is_logged_in()) {         // logged in
            $this->redirect_user();
        } elseif ($this->oc_auth->is_logged_in(FALSE)) {      // logged in, not activated
            redirect('/auth/send_again/');
        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'oc_auth') AND
                    $this->config->item('use_username', 'oc_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'oc_auth');

            $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'oc_auth') AND ( $login = $this->input->post('login'))) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
            }
            $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'oc_auth');
            $data['errors'] = array();

            if ($this->form_validation->run()) {        // validation ok
				
                if ($this->oc_auth->login($this->form_validation->set_value('login'), $this->form_validation->set_value('password'), $this->form_validation->set_value('remember'), $data['login_by_username'], $data['login_by_email'])) {        // success
				
				
					
				
                    $this->redirect_user();
                } else {
						
                    $errors = $this->oc_auth->get_error_message();
                    if (isset($errors['banned'])) {        // banned user
                        $this->_show_message($this->lang->line('auth_message_banned') . ' ' . $errors['banned']);
                    } elseif (isset($errors['not_activated'])) {    // not activated user
                        redirect('/auth/send_again/');
                    } else {             // fail
                        foreach ($errors as $k => $v)
                            $data['errors'][$k] = $this->lang->line($v);
                    }
                }
            }

            $referer = $this->input->get('referer');
            if (!empty($referer) && filter_var($referer, FILTER_VALIDATE_URL)) {
                $data['referer'] = $referer;
            }

            $data['show_captcha'] = FALSE;
            $layout = new Layout();
            $layout->set_title("Identifiez-vous");
            $layout->view('auth/login_form', $data, 'front_page');
        }
    }

    function redirect_user() {
        $referer = $this->input->post('referer');
        if (!empty($referer) && filter_var($referer, FILTER_VALIDATE_URL)) {
            redirect($referer);
        } else {
            $user_id = $this->oc_auth->get_user_id();
            $user_model = new User_model();
            $user = $user_model->get_user_by_uid($user_id);
            $role_id = $user->role_id;
            if ($role_id == 1) {
                redirect('/administrator/dashboard');
            } elseif ($role_id == 2) {
                redirect('/user/dashboard');
            } else {
                redirect('');
            }
        }
    }

    /**
     * Logout user
     *
     * @return void
     */
    function logout() {
        $this->oc_auth->logout();
        $this->_show_message($this->lang->line('auth_message_logged_out'));
    }

    /**
     * Show info message
     *
     * @param	string
     * @return	void
     */
    function _show_message($message) {
        $this->session->set_flashdata('message', $message);
        redirect('/auth/');
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */