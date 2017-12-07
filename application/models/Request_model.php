<?php

class Request_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_request_by_uid($uid) {
        $this->db->select("*")
                ->from('marketing_request')
                ->where('user = "' . $uid . '"');
        $db = $this->db->get();
        return $db->result();
    }

    public function get_request_by_id($request_id) {
        $this->db->select("*")
                ->from('marketing_request')
                ->where('request_id', $request_id);
        $db = $this->db->get();
        return $db->row(0);
    }
	
	public function get_campagne_by_id($campaign_id) {
        $this->db->select("*")
                ->from('marketing_sms_campaign')
                ->where('campaign_id', $campaign_id);
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_active_sms_campaign() {
		
		$data_now = date("Y-m-d");
        $this->db->select("*")
                ->from('marketing_sms_campaign')
                ->where("DATE_FORMAT(`sending_date`, '%Y-%m-%d') = '".$data_now."'");
        $db = $this->db->get();
        return $db->result();
    }
    
    public function save_request($request) {
        $this->db->insert('marketing_request', $request);
        return $this->db->insert_id();
    }

    public function save_campaign($request) {
        $this->db->insert('marketing_sms_campaign', $request);
        return $this->db->insert_id();
    }

}
