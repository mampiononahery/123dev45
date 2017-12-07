<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Alerte extends Back {
	
	
	public function alerte_tous()
	{
	
		$crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('alerte');
        $crud->set_subject('Alerte');
        $crud->set_relation('client_id', 'client', '{nom} {prenom}');
        $crud->add_action('Acquitter', '', 'user/alerte/close_alerte', 'fa fa-check-square-o');
        $crud->add_action('Fiche client', '', 'user/alerte/client', 'fa fa-user-o');
        $crud->columns('dt_real', 'note', 'client_id', 'acquitted');
		
		$user_log = $this->oc_auth->get_user_id();
		$crud->where('alerte.user', $user_log);
		$crud->unset_read();
        $user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($user_log);
		
		
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }

        $crud->field_type("user", "hidden", $this->oc_auth->get_user_id());
        $crud->unset_delete();

        $crud->display_as(array(
            'client_id' => 'Client',
            'dt_real' => 'Date',
            'acquitted' => 'Alerte acquitt&eacute;e',
            'email_send' => 'Email envoy&eacute;'
        ));

        $state = $crud->getState();

        $output = $crud->render();
		$output->latest_alert = 0;
        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
			
			
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $alerte_id = (int) $this->uri->segment(5);

        if ($alerte_id > 0) {
            $alerte_models = new Alerte_model();
            $output->current = $alerte_models->get_alerte_by_id($alerte_id);
        }

        $output->state = $state;

        $layout = new Layout();
        $layout->set_title("Alertes");
        $layout->view("sections/alerte", $output, 'user_page');
	
	}
	
    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('alerte');
        $crud->set_subject('Alerte');
		$user_log = $this->oc_auth->get_user_id();
        $crud->set_relation('client_id', 'client', '{nom} {prenom}',array('user' => $user_log));
        $crud->add_action('Acquitter', '', 'user/alerte/close_alerte', 'fa fa-check-square-o');
        $crud->add_action('Fiche client', '', 'user/alerte/client', 'fa fa-user-o');
        $crud->columns('dt_real', 'note', 'client_id', 'acquitted');
		
		
		
		//$crud->where('user', $user_log);
		$crud->where("acquitted=1 AND alerte.user = '".$user_log."'" );
		$crud->unset_read();
        $user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }
		
        $crud->field_type("user", "hidden", $this->oc_auth->get_user_id());
        $crud->unset_delete();

        $crud->display_as(array(
            'client_id' => 'Client',
            'dt_real' => 'Date',
            'acquitted' => 'Alerte acquitt&eacute;e',
            'email_send' => 'Email envoy&eacute;'
        ));

        $state = $crud->getState();

        $output = $crud->render();
		$output->latest_alert = 1;
        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
			
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $alerte_id = (int) $this->uri->segment(5);

        if ($alerte_id > 0) {
            $alerte_models = new Alerte_model();
            $output->current = $alerte_models->get_alerte_by_id($alerte_id);
        }

        $output->state = $state;

        $layout = new Layout();
        $layout->set_title("Alertes");
        $layout->view("sections/alerte", $output, 'user_page');
    }

    public function client() {
        $alerte_id = (int) $this->uri->segment(4);

        if ($alerte_id > 0) {
            $this->load->model('Alerte_model');
            $alerte_model = new Alerte_model();
            $alerte = $alerte_model->get_alerte_by_id($alerte_id);
            redirect('user/client/index/read/' . $alerte->client_id);
        } else {
            redirect('user/alerte');
        }
    }

    public function close_alerte() {
        $alerte_id =  $this->uri->segment(4);
		
        if ($alerte_id > 0) {
            $this->load->model('Alerte_model');
            $alerte_model = new Alerte_model();
            $alerte_model->close_alerte_by_id($alerte_id);
        }
        redirect('user/alerte');
    }

}
