<?php

class Ical_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    public function save_token($data_token) {
		
		
        $this->db->insert('token_ical', $data_token);
        
    }
	
	public function get_access($token,$user)
	{
		
		$this->db->select("*")
			->from("token_ical")
			->where("token='".$token."' AND user='".$user."'");
			
		$db = $this->db->get();
		return $db->result_array();
	}
	public function get_all_rendez_by_client($user)
	{
		
		$this->db->select("*")
			  ->from('rdv')
			  ->where('rdv.user="'.$user.'"');
		$db = $this->db->get();
        return $db->result();
	
	
		
	}
    

}
