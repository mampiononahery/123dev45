<?php

class Upload extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    public function insert_upload_file($data=array()){
        $this->db->insert_batch('client_object_entities',$data);
    }
    public function find_production_by_criteria($criteria, $uid) {
        $this->db->select("*")
                ->from('production')
                ->where("user = \"" . $uid . "\" AND prod_libelle LIKE \"%" . $criteria . "%\"");
        $db = $this->db->get();
        return $db->result();
    }
}

?>