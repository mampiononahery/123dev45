<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class Oc_auth {

    private $error = array();

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('User_model');
    }

    /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param	string	(username or email or both depending on settings in config file)
     * @param	string
     * @param	bool
     * @return	bool
     */
    function login($login, $password) {
        if ((strlen($login) == 0) OR ( strlen($password) == 0)) {
            return FAlSE;
        }

        $user_model = new User_model();
		
		

        if (!is_null($user = $user_model->get_user_by_uid($login))) { // login ok
			
            
			
			
			
			if ($this->authenticate($password, $user->password)) {  // password ok
               
				$this->ci->session->set_userdata(array(
                    'uid' => $user->uid,
                    'status' => ($user->is_crm == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                ));
                if ($user->is_crm == 0) {       // fail - not activated
                    $this->error = array('not_activated' => '');
                } else {
                    return TRUE;
                }
            } else {
			
                $this->error = array('login' => 'auth_incorrect_login');
            }
        } else {               // fail - wrong login
            $this->error = array('login' => 'auth_incorrect_login');
			
        }
        return FALSE;
    }

    /**
     * Logout user from the site
     *
     * @return	void
     */
    function logout() {
        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        $this->ci->session->set_userdata(array('uid' => '', 'status' => ''));
        $this->ci->session->sess_destroy();
    }

    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @return	bool
     */
    function is_logged_in($activated = TRUE) {
        return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
    }

    /**
     * Get user_id
     *
     * @return	string
     */
    function get_user_id() {
        return $this->ci->session->userdata('uid');
    }

    /**
     * Get error message.
     * Can be invoked after any failed operation such as login or register.
     *
     * @return	string
     */
    function get_error_message() {
        return $this->error;
    }

    function authenticate($password, $storedHash, $newHash = '')
	{
        require_once ($this->ci->config->item('owncloud_base_path'));
		/**
		* ACTIVATE IN TEST CLOUD
		*
		*/
		
		return true;
        if (\OC::$server->getHasher()->verify($password, $storedHash, $newHash)) {
            return TRUE;
        }
		
        return FALSE;
    }

    function hash_password($password) {
        require_once ($this->ci->config->item('owncloud_base_path'));
        return (string) \OC::$server->getHasher()->hash($password);
    }

}

/* End of file OC_auth.php */
/* Location: ./application/libraries/OC_auth.php */