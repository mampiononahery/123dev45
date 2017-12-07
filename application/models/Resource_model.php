<?php

class Resource_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function unset_default() {
        $data = array('is_default' => 0);
        return $this->db->update('resource', $data);
    }

    public function get_resources_by_uid($user) {
        $this->db->select("*")
                ->from('resource')
                ->where("user = '" . $user . "'");
        $db = $this->db->get();
        return $db->result();
    }

}
