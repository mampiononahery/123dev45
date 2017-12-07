<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_user_by_uid($uid) {
        $this->db->select("*")
                ->from('oc_users')
                ->where("uid = '" . $uid . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_resource_by_name($resource_name) {
        $this->db->select("id")
                ->from('user_resources')
                ->where("name LIKE '" . $resource_name . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_user_doc_by_uid($uid) {
        $this->db->select("typ_doc_id")
                ->from('user_doc')
                ->where("users = '" . $uid . "'");
        $db = $this->db->get();
        $items = $db->result();
        $list = '';
        foreach ($items AS $item) {
            $list.= ',' . $item->typ_doc_id;
        }
        return trim($list, ',');
    }

}
