<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Production extends Back {

    public function index() {
        $crud = new grocery_CRUD();
		$user_model = new User_model();
        $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
		
		if(!$logged_user->is_production){
			redirect('user/dashboard');
		
		}
       
		
		
		
        $crud->set_theme('flexigrid');
        $crud->set_table('production');
        $crud->set_subject('Production');
        $crud->set_field_upload('prod_image', 'assets/uploads/products');
        $crud->where('user', $this->oc_auth->get_user_id());
        $crud->columns('prod_image', 'prod_type', 'prod_libelle');

        $crud->field_type('user', 'hidden', $this->oc_auth->get_user_id());

        $crud->display_as(array(
            'user' => 'Utilisateur',
            'prod_image' => 'Image produit',
            'prod_type' => 'Cat&eacute;gorie',
            'prod_desc' => 'Description produit',
            'prod_libelle' => 'R&eacute;f&eacute;rence',
            'prod_tva' => 'TVA (%)',
            'prod_prix_ttc' => 'Prix TTC',
            'remise' => 'Remise (%)',
        ));

        
        if (!$logged_user->use_excel) {
            $crud->unset_export();
        }
		
        $output = $crud->render();

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $layout = new Layout();
        $layout->set_title("Production");
        $layout->view("sections/facturation", $output, 'user_page');
    }

}
