<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Facturation extends Back {

    public function index() {
        $crud = new grocery_CRUD();
		$user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
		/*
		if(!$logged_user->is_facturation){
			redirect('user/dashboard');
		
		}
       */
		
		
		
        $crud->set_theme('flexigrid');
        $crud->set_table('prd_rdv');
		$crud->set_relation('id_rdv', 'rdv', 'user');
        $crud->set_subject('Facturation');
        $crud->where('user', $this->oc_auth->get_user_id());
		
		 $crud->where('user="'.$this->oc_auth->get_user_id().'" OR prd_rdv.id_rdv = 0');
        $crud->columns('prod_label','prod_pu','qte','prod_remise','prod_prix_ttc');
        $crud->display_as(array(
            'prod_label' => 'Produit',
            'prod_pu' => 'Prix unitaire',
            'qte' => 'Quantite',
            'prod_remise' => 'Remise',
            'prod_prix_ttc' => 'Prix TTC'
            
        ));
        $crud->callback_column('prod_prix_ttc', array($this, 'callback_load_dynamic_fields'));
        $output = $crud->render();
        $layout = new Layout();
        $layout->set_title("Facturation");
        $layout->view("sections/facturation", $output, 'user_page');
    }
	
	function callback_load_dynamic_fields($value, $row) {
			$prix = ($row->prod_pu*$row->qte);
			if($row->prod_remise){
				
				$remise = ($row->prod_remise * $prix)/100;
				
				$prix  =$prix - $remise;
				
			
			}
			return $prix;
	}

}
