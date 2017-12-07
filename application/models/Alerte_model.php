<?php

class Alerte_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_alerte_by_id($alerte_id) {
        $this->db->select("*")
                ->from('alerte')
                ->where("alerte_id = '" . $alerte_id . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_alertes_by_uid($user_id) {
        $this->db->select("*")
                ->from('alerte')
                ->join('client', 'alerte.client_id = client.client_id')
                ->where("alerte.user = '" . $user_id . "' AND acquitted = 0");
				
						
        $db = $this->db->get();
        return $db->result();
    }
	
    public function get_alertes_by_uid_by_type($user_id,$acquitted =0) {
        $this->db->select("*")
                ->from('alerte')
                ->join('client', 'alerte.client_id = client.client_id')
                ->where("alerte.user = '" . $user_id . "' ");
				
				
		if($acquitted>0)
		{
			$this->db->where("acquitted",$acquitted);
			
		
		}
				
        $db = $this->db->get();
        return $db->result();
    }

    public function get_cron_alertes() {
        $this->db->select('alerte.*, nom, prenom, pays, adresse, cp, ville, tel_fixe, tel_mobile')
                ->from('alerte')
                ->join('client', 'alerte.client_id = client.client_id')
                ->where('acquitted = 0 AND date(dt_real) <= now()')
                ->order_by('alerte.client_id', 'ASC');
        $db = $this->db->get();
        return $db->result();
    }

    function close_alerte_by_id($alerte_id) {
        $data = array(
            "acquitted" => 1
        );
        $this->db->where('alerte_id', $alerte_id);
        return $this->db->update('alerte', $data);
    }

}
