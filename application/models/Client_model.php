<?php

class Client_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_clients_by_uid($uid,$order_by = array(),$where = array()) {
        $this->db->select("*")
                ->from('client')
                ->where('user = "' . $uid . '"');
		if(sizeof($where) && !empty($where['search_field']) && $where['search_field']!='')
		{
			$this->db->where($where['search_field']." LIKE '%".$where['search_text']."%'");

		}
		if(sizeof($order_by))
		{
			if($order_by[0]!='' && $order_by[1]!='')
			{
				$this->db->order_by($order_by[0],$order_by[1]);
			}
		}
		
        $db = $this->db->get();
        return $db->result();
    }

    public function get_client_closed_birthday($uid, $date) {
		
        $this->db->select("*")
                ->from('client')
                ->where('user = "' . $uid . '" AND dt_nais LIKE "%' . $date . '" AND sms_versaire=1');
        $db = $this->db->get();
        return $db->result();
    }
	
    public function get_object_closed_birthday($uid, $date) {
        /**
         * find client
         */
        $this->db->select("*")
                ->from('client')
                ->where('user = "' . $uid . '"');
        $db = $this->db->get();
        $clients = $db->result();
        
        /**
         * find related client objects
         */
        $data_clients = array();
        $data_objects = array();
        $result = array();
        foreach ($clients AS $client) {
            $this->db->select("*")
                    ->from('client_object_entities')
                    ->where('client_id = ' . $client->client_id);
            $db = $this->db->get();
            $objects = $db->result();
            
            $has_objects = false;
            foreach ($objects AS $object) {
                $dynamic_fields = json_decode($object->dynamic_fields, true);
				//empty($dynamic_fields[7])
				if(!empty($dynamic_fields[8]) )
				{
					if($dynamic_fields[8])
					{
					
					
						$name = $dynamic_fields[1];
						$race = $dynamic_fields[3];
						$birthdate = $dynamic_fields[2];
						
						if($birthdate!=""){
						
							$temp = explode("/",$birthdate);
							if(sizeof($temp)==3)
							{
								$birthdate = $temp[2].'-'.$temp[1].'-'.$temp[0];
							}
							
							$date_compare = explode('-', $birthdate);
							$date2 = '-' . $date_compare[1] . '-' . $date_compare[2];
							if ($date2 == $date) {
								$a = array(
									'name' => $name,
									'race' => $race,
									'birthdate' => $birthdate
								);
								array_push($data_objects, $a);
								$has_objects = true;
							}
						}
					}
				}
            }
            if ($has_objects) {
                $data_clients = array(
                    'client' => json_decode(json_encode($client), true),
                    'objects' => $data_objects,
                );
                array_push($result, $data_clients);
            }
        }
		
        return $result;
    }

    public function get_client_by_id($client_id) {
        $this->db->select("*")
                ->from('client')
                ->where("client_id = '" . $client_id . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function find_client_by_criteria($criteria) {
        $this->db->select("*")
                ->from('client')
                ->where("nom LIKE \"%" . $criteria . "%\" OR prenom LIKE \"%" . $criteria . "%\" OR adresse LIKE \"%" . $criteria . "%\" OR pays LIKE \"%" . $criteria . "%\"");
        $db = $this->db->get();
        return $db->result();
    }

    public function find_cities_by_criteria($criteria) {
        $this->db->select("*")
                ->from('cities')
                ->where("postal_code LIKE \"" . $criteria . "%\" OR postal_code LIKE \"%-" . $criteria . "%\"");
        $db = $this->db->get();
        return $db->result();
    }

    function update_messaging_status($client_id, $status_id) {
        $data = array(
            'sms_versaire' => $status_id
        );
        $this->db->where('client_id', $client_id);
        return $this->db->update('client', $data);
    }

    function get_client_fields() {
        $this->db->select("*")
                ->from('client_fields');
        $db = $this->db->get();
        return $db->result();
    }

    function get_client_field_by_field_id($field_id) {
        $this->db->select("*")
                ->from('client_fields')
                ->where('field_id', $field_id);
        $db = $this->db->get();
        return $db->row(0);
    }

    function get_client_field_option_value($option_id) {
        $this->db->select("*")
                ->from('client_options')
                ->where('option_id', $option_id);
        $db = $this->db->get();
        return $db->row(0);
    }

    function get_client_fields_by_user($uid) {
        $this->db->select("*")
                ->from('client_fields_filter')
                ->join('client_fields', 'client_fields_filter.field_id = client_fields.field_id')
                ->where('client_fields_filter.uid', $uid)
				->where('client_fields_filter.field_id <> 5 ');
		$this->db->group_by('client_fields.label');
        $db = $this->db->get();
        return $db->result();
    }

    function get_client_field_options($field_id) {
        $this->db->select("*")
                ->from('client_field_options')
                ->join('client_options', 'client_options.option_id = client_field_options.option_id')
                ->where('client_field_options.field_id', $field_id);
        $db = $this->db->get();
        return $db->result();
    }

    function get_client_object_field_options($field_id) {
        $this->db->select("*")
                ->from('client_object_field_options')
                ->join('client_options', 'client_options.option_id = client_object_field_options.option_id')
                ->where('client_object_field_options.field_id', $field_id);
        $db = $this->db->get();
        return $db->result();
    }

    function get_client_object_fields_by_object_id($object_id) {
        $this->db->select("*")
                ->from('client_object_fields')
                ->where('object_id', $object_id);
        $db = $this->db->get();
        return $db->result();
    }

    public function get_object_by_id($object_id) {
        $this->db->select("*")
                ->from('client_object_entities')
                ->where("entity_id = '" . $object_id . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function save_client_option($options) {
        $this->db->insert('client_options', $options);
        return $this->db->insert_id();
    }

    public function save_field_option($options) {
        $this->db->insert('client_field_options', $options);
        return $this->db->insert_id();
    }

    function test_client_query($uid, $table_field, $table_condition, $table_value) {
        $this->db->select("*")
                ->from('client');
        switch ($table_condition) {
            case '~': {
                    $this->db->where('client.user = "' . $uid . '" AND lower(' . $table_field . ') LIKE lower("' . $table_value . '%")');
                }break;
            case '=': {
                    $this->db->where('client.user = "' . $uid . '" AND ' . $table_field . ' = "' . $table_value . '"');
                }break;
            case '<=': {
                    $this->db->where('client.user = "' . $uid . '" AND ' . $table_field . ' <= ' . $table_value);
                }break;
            case '>=': {
                    $this->db->where('client.user = "' . $uid . '" AND ' . $table_field . ' >= ' . $table_value);
                }break;
        }
        $db = $this->db->get();
        return $db->result();
    }

    function get_client_by_ids($ids,$array_filtre = array(),$sort_val='',$sort_col='',$id_client=0) {
	
	
		
       	
		$sql_object = " SELECT client_id,object_id FROM client_object_entities WHERE 1 = 1 GROUP BY object_id,client_id ";
		$sql_in_array= "SELECT * FROM client_object_entities WHERE 0 > 1 ";
		if($id_client>0)
		{
			$sql_in_array= "SELECT * FROM client_object_entities WHERE 1 = 1 ";
		}
		$sql = "SELECT c.*,o.object_name,obj.object_id, obj.dynamic_fields as dynamic_object FROM client c 
		LEFT JOIN (".$sql_object.") co ON c.client_id = co.client_id
		LEFT JOIN client_objects o ON co.object_id=o.object_id 
		LEFT JOIN (".$sql_in_array.") as obj ON c.client_id = obj.client_id 
		WHERE c.client_id IN (".$ids.")";
		
		if(sizeof($array_filtre ))
		{
		   if(isset($array_filtre['namesearch']) && $array_filtre['namesearch']!='' && $array_filtre['namesearchval']!='' )
		   {
				
				
				$sql .=' AND '.$array_filtre['namesearch'].' LIKE "%'.$array_filtre['namesearchval'].'%"';
		   }
		}
		
		
		
		if($sort_val!="" && $sort_col!=""){
			$sql .=" ORDER BY ".$sort_col." ".$sort_val;
		}
		else{
			$sql .=" ORDER BY c.client_id ASC ";
		}
		$db = $this->db->query($sql);
		$resultat = $db->result_array();
		
		
		$res_retour = array();
		if(sizeof($resultat)){
			foreach($resultat as $cli){
				
				$client_fields = $this->get_client_fields_by_user($cli["user"]);
				
				$dynamic_fields = json_decode($cli["dynamic_fields"] , true);
				foreach ($client_fields AS $item)
				{
					if (!empty($item->label)) 
					{
						
						if ($item->field_type == 'boolean')
						{
							
							$checked = "";
							if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 1))
							{
								$checked = "OUI";
							}
							if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 0)) {
								$checked = 'NON';
							} 
							$cli[$item->label] = $checked;
							
						}
						elseif ($item->field_type == 'dropdown') 
						{
							$selected = "";
							$field_options = $this->get_client_field_options($item->field_id);
							 foreach ($field_options AS $option){
								if (isset($dynamic_fields[$item->field_id]) && $dynamic_fields[$item->field_id] == $option->option_id){
									$selected = $option->option_value;
									break;
								}
							 }
							 $cli[$item->label] = $selected;
							
						}
						else {
							$value = "";
							if ((isset($dynamic_fields[$item->field_id]))){
								$value = $dynamic_fields[$item->field_id];
								
							}
							$cli[$item->label] = $value;
							/* var_dump($item->label);
							var_dump($value);*/
						}
					}
				}
				unset($cli["dynamic_fields"]);
				
				
				$object = $this->get_client_object_fields_by_object_id($cli["object_id"]);
				
				if(sizeof($object)>0)
				{
					
					$dynamic_fields_o = json_decode($cli["dynamic_object"], true);
					foreach ($object AS $item){
						if (!empty($item->label)) {
						
							if ($item->field_type == 'boolean') {
								$is_selected = "Non";
								 if ((isset($dynamic_fields_o[$item->field_id]) && intval($dynamic_fields_o[$item->field_id]) == 1)) {
									$is_selected = "Oui";
								 
								 }
								$cli[$item->label] = $is_selected;
							}
							
							elseif ($item->field_type == 'dropdown') {
							
								$field_options = $this->get_client_object_field_options($item->field_id);
								$selected = "";
								foreach ($field_options AS $option)
								{	
									 if (isset($dynamic_fields_o[$item->field_id]) && $dynamic_fields_o[$item->field_id] == $option->option_id) {
										$selected = $option->option_value;
										break;
									 }
								}
								$cli[$item->label] = $selected;
							}
							else {
								if ((isset($dynamic_fields_o[$item->field_id]))) {
									$value = $dynamic_fields_o[$item->field_id];
								} else {
									$value = '';
								}
								
								$cli[$item->label] = $value;
							
							
							}
						
						
								
						}
				
				
					}
					
					
					
				}
				
				unset($cli["dynamic_object"]);
				
				$res_retour[] = (object)$cli;
				
				
				
			}
			
		}
		
		return $res_retour;
		
        //return $db->result();
    }

}
