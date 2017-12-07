<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Back extends MX_Controller {

    public $_alertes;
    public $_user;

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('layout');
        $this->load->library('oc_auth');
        $this->load->library('grocery_CRUD');
        $this->load->model('User_model');
        $this->load->model('Alerte_model');
		$this->load->model('Ical_model');

        if (!$this->oc_auth->is_logged_in()) {
		
			/**
			* A COMMENTER
			* 
			*/
		
            redirect('auth/login?referer=' . current_url());
        } else {
            /* current user */
            $user_id = $this->oc_auth->get_user_id();
            $user_model = new User_model();
            $user = $user_model->get_user_by_uid($user_id);

            /* active alertes */
            $alerte_models = new Alerte_model();
            $this->_alertes = $alerte_models->get_alertes_by_uid($user_id);

            $this->_user = $user;

            /* ACL */
            $this->load->library('Acl');

            $resource_name = $this->uri->segment(1);
            $resource = $user_model->get_resource_by_name($resource_name);
			
            if (isset($resource) && !empty($resource)) {
                $role_id = $user->role_id;
                $resource_id = $resource->id;

                $action = $this->uri->segment(4);
                if ($action == 'edit' && (!$this->acl->can_modify($role_id, $resource_id))) {
                    die("Vous n'êtes pas autorisé à accéder à cette page");
                }
                switch ($action) {
                    case 'add': {
                            if ((!$this->acl->can_write($role_id, $resource_id))) {
                                die("Vous n'êtes pas autorisé à accéder à cette page");
                            }
                        } break;
                    case 'edit': {
                            if ((!$this->acl->can_modify($role_id, $resource_id))) {
                                die("Vous n'êtes pas autorisé à accéder à cette page");
                            }
                        } break;
                    case 'delete': {
                            if ((!$this->acl->can_delete($role_id, $resource_id))) {
                                die("Vous n'êtes pas autorisé à accéder à cette page");
                            }
                        } break;
                    default : {
                            if ((!$this->acl->can_read($role_id, $resource_id))) {
                                die("Vous n'êtes pas autorisé à accéder à cette page");
                            }
                        } break;
                }
            } else {
                redirect('auth/login?referer=' . current_url());
            }
            /* END ACL */
        }
    }

    function password_generator($post_array) {
		
	
        $post_array['password'] = $this->oc_auth->hash_password($post_array['new_password']);
        unset($post_array['new_password']);
        unset($post_array['verify_password']);
		
		
        return $post_array;
    }

    function _launch_query($table_selection, $table_field, $table_condition, $table_value) {
        $this->load->model('Client_model');
        $this->load->model('Rdv_model');

        $client_model = new Client_model();
        $rdv_model = new Rdv_model();

        $result = array();
        $table = '';
        $uid = $this->oc_auth->get_user_id();

        $array_size = sizeof($table_selection);
        if ($array_size <= 0) {
            return false;
        }

        for ($i = 0; $i < $array_size; $i++) {
            $table = $table_selection[$i];
            switch ($table_selection[$i]) {
                case 'client': {
                        $result[$i] = $client_model->test_client_query($uid, $table_field[$i], $table_condition[$i], $table_value[$i]);
                    }break;
                case 'rdv': {
                        $result[$i] = $rdv_model->test_rdv_query($uid, $table_field[$i], $table_condition[$i], $table_value[$i]);
                    }break;
                case 'prd_rdv': {
                        $result[$i] = $rdv_model->test_prd_rdv_query($uid, $table_field[$i], $table_condition[$i], $table_value[$i]);
                    }break;
            }
        }
        return $result;
    }

    function _prepare_result($table, $result, $operator) {
        $first_row = array();
        $size = sizeof($result);

        for ($i = 0; $i < $size; $i++) {
            $current = array();
            foreach ($result[$i] AS $item) { // row
                $key = $table . '_id';
                array_push($current, $item->$key);
            }
            if ($i == 0) {
                $first_row = $current;
            } elseif ($i > 0) {
                $op = $operator[$i];
                if ($op == 'or') {
                    $first_row = array_merge($current, $first_row);
                } else {
                    $first_row = array_intersect($first_row, $current);
                }
            } else {
                $first_row = $current;
            }
        }

        return array_unique($first_row);
    }


    function _final_result($table, $result,$filtre=array(),$sort_val="",$sort_col="",$id_client=0,$select_distinct="") {
        $this->load->model('Client_model');
        $this->load->model('Rdv_model');

        $client_model = new Client_model();
        $rdv_model = new Rdv_model();

        $ids = implode(',', $result);

        $return = array();

        if (strlen($ids) > 0) {
            switch ($table) {
                case 'client': {
                        $return = $client_model->get_client_by_ids($ids,$filtre,$sort_val,$sort_col,$id_client);
                    }break;
                case 'rdv': {
						
                        $return = $rdv_model->get_rdv_by_ids($ids,$filtre,$sort_val,$sort_col,$id_client,$select_distinct);
						
						
                    }break;
                case 'prd_rdv': {
				
                        $return = $rdv_model->get_prd_rdv_by_ids($ids,$filtre,$sort_val,$sort_col,$id_client,$select_distinct);
                    }break;
            }
        }

        return $return;
    }

    function _send_campaign($data, $campaign) {
        $this->load->library('api_sms');

        $client_array = array();
        foreach ($data AS $entity) {
            if (isset($entity->client_id) && in_array($entity->client_id, $client_array)) {
                // do nothing
            } else {
                array_push($client_array, $entity->client_id);
                if (isset($entity->tel_mobile) && !empty($entity->tel_mobile)) {
                    $formatted_number = str_replace('+', '00', $entity->tel_mobile);
                    $api_sms = new Api_sms();
                    $api_sms->set_destination_number($formatted_number);

                    $str1 = str_replace('%NOM%', $entity->nom, strip_tags($campaign->message));
                    $str2 = str_replace('%PRENOM%', $entity->prenom, $str1);

                    $api_sms->set_sms(strip_tags($str2));
                    $api_sms->send_sms();

                    $this->load->model('Sms_model');
                    $message_log = array(
                        'user' => $campaign->user,
                        "request_id" => $campaign->request_id,
                        'phone_number' => $formatted_number,
                        'message' => $str2,
                        'sending_date' => date('Y-m-d h:i:s'),
                        'sending_type' => 'Campagne'
                    );
                    $sms_log_model = new Sms_model();
                    $sms_log_model->save_log($message_log);
                }
            }
        }
    }
	/**
	*
	* Calback attentite
	*/
	
	function callbak_entity_title($value, $row) {
        $this->load->model('Client_model');
        $client_model = new Client_model();

        $object = $client_model->get_object_by_id($row->entity_id);
        if (!empty($object) && isset($object->dynamic_fields) && !empty($object->dynamic_fields)) {
            $dynamic_fields = json_decode($object->dynamic_fields, true);
            return !empty($dynamic_fields[1]) ? $dynamic_fields[1] : 'Non défini';
        } else {
            return 'Non défini';
        }
    }
	
	function callbak_prod_libelle($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();

		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$libelle_prod = !empty($rdv_prod[0]->prod_libelle) ? $rdv_prod[0]->prod_libelle : ' - ';
		return $libelle_prod;
	
	
	}
	function callbak_prod_type($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
	
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$libelle_prod = !empty($rdv_prod[0]->prod_type) ? $rdv_prod[0]->prod_type : ' - ';
		return $libelle_prod;
	
	
	}
	function callbak_prod_pu($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
	
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$libelle_prod = !empty($rdv_prod[0]->prod_pu) ? $rdv_prod[0]->prod_pu ." &euro;": '0';
		return $libelle_prod;
	
	
	}
	
	function callbak_qte($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
	
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$libelle_prod = !empty($rdv_prod[0]->qte) ? $rdv_prod[0]->qte : ' ';
		return $libelle_prod;
	
	
	}
	function callbak_prod_remise($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
	
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$libelle_prod = !empty($rdv_prod[0]->prod_remise) ? $rdv_prod[0]->prod_remise ." %" : ' 0 %';
		return $libelle_prod;
	
	
	}
	
	function callbak_total($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$total = 0;
		if(!empty($rdv_prod[0])){
		
			$total = ($rdv_prod[0]->prod_pu*$rdv_prod[0]->qte * (1 - $rdv_prod[0]->prod_remise /100)) ;
		}
		
		return $total;
		
		
		
	
	
	}
	
	function callbak_date_commande($value,$row)
	{
	
		$this->load->model('Rdv_model');
		$rdv = new Rdv_model();
		$rdv_prod = $rdv->get_prd_rdv_by_rdv_id($row->id_rdv);
		$date_start = "";
		if(!empty($rdv_prod[0]->date_start_rendevous)){
			$date_start = $rdv_prod[0]->date_start_rendevous;
			
		}
		
		return $date_start;
		
		
		
	
	
	}
	
	

}
