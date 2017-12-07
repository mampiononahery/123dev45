<?php

class Production_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_production_by_criteria($criteria, $uid) {
        $this->db->select("*")
                ->from('production')
                ->where("user = \"" . $uid . "\" AND prod_libelle LIKE \"%" . $criteria . "%\"");
        $db = $this->db->get();
        return $db->result();
    }

}
