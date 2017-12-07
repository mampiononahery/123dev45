<?php

class Rdv_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	public function get_client_by_rdv($rdv_id)
	{
		$this->db->select("*")
			  ->from('rdv')
			  ->join('client','rdv.id_client=client.client_id')
			  ->where('rdv.rdv_id',$rdv_id);
		$db = $this->db->get();
        return $db->row(0);
	
	}
    public function get_rdv_by_id($rdv_id) {
        $this->db->select("*")
                ->from('rdv')
                ->where('rdv_id', $rdv_id);
        $db = $this->db->get();
        return $db->row(0);
    }

	
	//GROUP_CONCAT(pg.value SEPARATOR ',') AS score_value
	
	
	public function get_les_produit_by_rendevous($rdv_id)
	{
		
		$this->db->select("*,DATE_FORMAT(dt_start,'%d/%m/%Y') as date_start_rendevous,
		 GROUP_CONCAT( CONCAT(prod_label,CONCAT('(',CONCAT(prd_rdv.qte,') ')) ) SEPARATOR ',') as production_libelle");
		$this->db->from('prd_rdv')
				->join('production', 'production.prod_id = prd_rdv.id_prd')
				->join('rdv', 'prd_rdv.id_rdv = rdv.rdv_id')
				->where('id_rdv', $rdv_id);
		$this->db->group_by('id_rdv'); 
		  
		$db = $this->db->get();
        return $db->result();
		
	}
	
	
    public function get_prd_rdv_by_rdv_id($rdv_id) {
        $this->db->select("*,DATE_FORMAT(dt_start,'%d/%m/%Y') as date_start_rendevous,
			((prod_pu*qte)-(prod_pu*qte*prod_remise/100)) as prix
		
		
		")
                ->from('prd_rdv')
                ->join('production', 'production.prod_id = prd_rdv.id_prd')
                ->join('rdv', 'prd_rdv.id_rdv = rdv.rdv_id')
                ->where('id_rdv', $rdv_id);
        $db = $this->db->get();
        return $db->result();
    }

    public function get_prd_rdv_by_client_id($client_id) {
        $this->db->select("*")
                ->from('prd_rdv')
                ->join('production', 'production.prod_id = prd_rdv.id_prd')
                ->join('rdv', 'prd_rdv.id_rdv = rdv.rdv_id')
                ->where('rdv.id_client', $client_id);
        $db = $this->db->get();
        return $db->result();
    }

    public function get_all_rdv_by_uid($uid,$id_ressource=0) {
        $this->db->select("rdv.*,client.*,marketing_sms_logs.log_id")
                ->from('rdv')
                ->join('client', 'rdv.id_client = client.client_id')
				->join("marketing_sms_logs","rdv.rdv_id=marketing_sms_logs.rdv_id","LEFT")
                ->where('rdv.user', $uid);
				
		if($id_ressource>0){
		
			$this->db->where("rdv.id_ressource",$id_ressource);
		
		
		}
				
			
        $db = $this->db->get();
		
		
	
        return $db->result();
    }

    public function get_rdv_closed_date($uid, $date) {
	
		$this->db->select("*")
                ->from('rdv')
                ->join('client', 'rdv.id_client = client.client_id')
                ->where('rdv.user = "' . $uid . '" AND rdv.dt_start LIKE "%' . $date . '%"');
        $db = $this->db->get();
        return $db->result();
    }

    public function save_rdv($rdv) {
        $this->db->insert('rdv', $rdv);
        return $this->db->insert_id();
    }

    public function save_prd_rdv($prd_rdv) {
        $this->db->insert('prd_rdv', $prd_rdv);
        return $this->db->insert_id();
    }

    public function update_rdv($rdv, $rdv_id) {
        $this->db->update('rdv', $rdv, array('rdv_id' => $rdv_id));
    }

    public function delete_prd_rdv($rdv_id) {
        $this->db->delete('prd_rdv', array('id_rdv' => $rdv_id));
    }

    public function delete_rdv($rdv_id) {
        $this->db->delete('rdv', array('rdv_id' => $rdv_id));
    }

    function test_rdv_query($uid, $table_field, $table_condition, $table_value) {
        $this->db->select("rdv_id")
                ->from('rdv');
        switch ($table_condition) {
            case '~': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' LIKE "%' . $table_value . '%"');
                }break;
            case '=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' = "' . $table_value . '"');
                }break;
            case '<=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' <= "' . $table_value . '"');
                }break;
            case '>=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' >= "' . $table_value . '"');
                }break;
        }
        $db = $this->db->get();
        return $db->result();
    }

    function test_prd_rdv_query($uid, $table_field, $table_condition, $table_value) {
        $this->db->select("*")
                ->from('rdv')
                ->join('prd_rdv', 'rdv.rdv_id = prd_rdv.id_rdv')
                ->join('resource', 'rdv.id_ressource = resource.resource_id')
                ->join('client', 'rdv.id_client = client.client_id');
        switch ($table_condition) {
            case '~': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' LIKE "' . $table_value . '%"');
                }break;
            case '=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' = "' . $table_value . '"');
                }break;
            case '<=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' <= "' . $table_value . '"');
                }break;
            case '>=': {
                    $this->db->where('rdv.user = "' . $uid . '" AND ' . $table_field . ' >= "' . $table_value . '"');
                }break;
        }
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
	
    function get_client_object_fields_by_object_id($object_id) {
        $this->db->select("*")
                ->from('client_object_fields')
                ->where('object_id', $object_id);
        $db = $this->db->get();
        return $db->result();
    }
	function get_client_fields_by_user($uid) {
        $this->db->select("*")
                ->from('client_fields_filter')
                ->join('client_fields', 'client_fields_filter.field_id = client_fields.field_id')
                ->where('client_fields_filter.uid', $uid);
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
    function get_rdv_by_ids($ids,$array_filtre= array(),$sort_val='',$sort_col='',$id_client,$select_distinct="") {
	
		$sql_object = " SELECT client_id,object_id FROM client_object_entities WHERE 1 = 1 GROUP BY object_id,client_id ";
		$sql_in_array= "SELECT * FROM client_object_entities WHERE 0 > 1 ";
		if($id_client>0)
		{
			$sql_in_array= "SELECT * FROM client_object_entities WHERE 1 = 1 ";
		}
		$is_group_by = 0;
		if($select_distinct!=""){
			
			$sql_distinct = $select_distinct;
			$is_group_by = 1;
		}
		else{
			$sql_distinct = "rdv.*,resource.*,client.*,client_objects.object_name,objet.object_id, in_filtre.dynamic_fields as dynamic_object";
			
		}
		$this->db->select($sql_distinct)
                ->from('rdv')
                ->join('resource', 'rdv.id_ressource = resource.resource_id')
                ->join('client', 'rdv.id_client = client.client_id')
				->join('( '.$sql_object.' ) as objet ','client.client_id=objet.client_id','LEFT')
				
				->join('client_objects','objet.object_id=client_objects.object_id','LEFT')
				
				->join('('.$sql_in_array.') as in_filtre','client.client_id=in_filtre.client_id','LEFT')
                ->where('rdv_id IN(' . $ids . ')');
				
		if(sizeof($array_filtre ))
		{
		   if(isset($array_filtre['namesearch']) && $array_filtre['namesearch']!='' && $array_filtre['namesearchval']!='' )
		   {
				$this->db->where($array_filtre['namesearch'].' LIKE "%'.$array_filtre['namesearchval'].'%"');
		   }
		}
		if($is_group_by)
		{
			$this->db->group_by($select_distinct);
		}
		if($sort_val!="" && $sort_col!=""){
			$this->db->order_by( $sort_col , $sort_val );
		}
		
        $db = $this->db->get();
		
		
		$resultat = $db->result_array();
		
		// GET LIST dynamique file
		$res_retour = array();
		if(sizeof($resultat)){
			foreach($resultat as $cli){
				if(!empty($cli["user"])){
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
				
				// DYNAMIC FILE ///
				}
				if(!empty($cli["object_id"])){
				
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
				
				
				}
				
				
				$res_retour[] = (object)$cli;
			}
			
		}
		
		return $res_retour;
		
		
		
		
       // return $db->result();
    }

    function get_prd_rdv_by_ids($ids,$array_filtre= array(),$sort_val='',$sort_col='',$id_client=0,$sql_distinct="") {
	
	
		$sql_object = " SELECT client_id,object_id FROM client_object_entities WHERE 1 = 1 GROUP BY object_id,client_id ";
		$sql_in_array= "SELECT * FROM client_object_entities WHERE 0 > 1 ";
		if($id_client>0)
		{
			$sql_in_array= "SELECT * FROM client_object_entities WHERE 1 = 1 ";
		}
		$is_grouby =  0;
		if($sql_distinct!=""){
			
			$sql_distinct = $sql_distinct;
			$is_grouby =  1;
			
		}
		else{
			$sql_distinct = "rdv.*,prd_rdv.*,resource.*,client.*,client_objects.object_name,objet.object_id, in_filtre.dynamic_fields as dynamic_object";
			
		}
		
		
		
       $this->db->select($sql_distinct)
                ->from('rdv')
                ->join('prd_rdv', 'rdv.rdv_id = prd_rdv.id_rdv')
                ->join('resource', 'rdv.id_ressource = resource.resource_id')
                ->join('client', 'rdv.id_client = client.client_id')
				->join('('.$sql_object.') as objet ','client.client_id=objet.client_id','LEFT')
				->join('client_objects','objet.object_id=client_objects.object_id','LEFT')
				
				->join('('.$sql_in_array.') as in_filtre','client.client_id=in_filtre.client_id','LEFT')
				
				
				
                ->where('prd_rdv_id IN(' . $ids . ')');
				
				
			if(sizeof($array_filtre ))
			{
			   if(isset($array_filtre['namesearch']) && $array_filtre['namesearch']!='' && $array_filtre['namesearchval']!='' )
			   {
					$this->db->where($array_filtre['namesearch'].' LIKE "%'.$array_filtre['namesearchval'].'%"');
			   }
			}
			
		if($is_grouby){
			
			
			$this->db->group_by($sql_distinct);
		}	
			
		if($sort_val!="" && $sort_col!=""){
			$this->db->order_by( $sort_col , $sort_val);
		}
			
        $db = $this->db->get();
        $resultat = $db->result_array();
		
		// GET LIST dynamique file
		$res_retour = array();
		if(sizeof($resultat)){
			foreach($resultat as $cli){
			
				if(!empty($cli["user"])){
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
				}
				
				if(!empty($cli["object_id"])){
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
				
				}
				
				$res_retour[] = (object)$cli;
			}
			
		}
		
		return $res_retour;
    }

}
