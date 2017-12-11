<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Importation extends Back {

    public function index() {
        $crud = new grocery_CRUD();
        // $output = $crud->field_type('input','file');
        $crud->set_theme('flexigrid');
        $crud->set_table('oc_users');
          $crud->set_relation('role_id', 'user_roles', 'name');
        $crud->set_relation('couleur_fond', 'color', 'color_name');
        $crud->set_relation_n_n('nom_type', 'user_doc', 'type_doc', 'users', 'typ_doc_id', 'nom_type');
        $crud->set_relation_n_n('client_fields', 'client_fields_filter', 'client_fields', 'uid', 'field_id', '{client_fields.field_id} - {label}');
        $crud->set_field_upload('photo_use', 'assets/uploads/profile');
        $crud->field_type('is_crm', 'true_false');


        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_export();
        $crud->unset_print();
        $crud->unset_columns();
        $crud->unset_edit_fields();
        $crud->unset_columns();

         
        $crud->field_type('is_sms', 'true_false');
        $crud->field_type('use_excel', 'true_false');

        
        $crud->columns('photo_use', 'uid', 'displayname');
        $crud->fields('photo_use', 'uid', 'displayname', 'email_adress', 'couleur_fond', 'nom_type', 'client_fields', 'is_crm', 'is_sms', 'use_excel');
        $crud->display_as(array(
            'photo_use' => 'Avatar',
            'uid' => 'Login',
            
            'email_adress' => 'Adresse email',
            'displayname' => 'Nom complet',
            'nom_type' => 'Type de document',
            'client_fields' => 'Champs clients',
            'use_excel' => 'Export Excel',
            'is_crm' => 'Acc&eacute;s au CRM',
            'is_sms' => 'Acc&eacute;s aux SMS',
            'couleur_fond' => 'Background'
        ));

       //  $crud = new grocery_CRUD();
       //  $crud->set_theme('flexigrid');
       //  $crud->set_table('oc_users');
       //  $crud->set_relation('role_id', 'user_roles', 'name');
       //  $crud->set_relation('couleur_fond', 'color', 'color_name');
       //  $crud->set_relation_n_n('nom_type', 'user_doc', 'type_doc', 'users', 'typ_doc_id', 'nom_type');
       //  $crud->set_relation_n_n('client_fields', 'client_fields_filter', 'client_fields', 'uid', 'field_id', '{client_fields.field_id} - {label}');
       //  $crud->set_field_upload('photo_use', 'assets/uploads/profile');
       //  $crud->unset_fields('password');

       // $crud->unset_add();
       //  $crud->unset_delete();
       //  $crud->unset_read();
       //  $crud->unset_export();
       //  $crud->unset_print();

       //  $crud->columns('photo_use', 'displayname', 'email_adress', 'nom_type');
       //  $crud->fields('photo_use');
       //  $crud->display_as(array(
       //      'photo_use' => 'Avatar',
       //      'uid' => 'Login',
       //      'email_adress' => 'Adresse email',
            
       //  ));

        $output ="";
        
                $layout = new Layout();
                $layout->set_title("Importation");
                $layout->view("sections/importation", $output, 'admin_page');
    }
    

    public function do_upload(){
      $config['upload_path'] = 'assets/uploads/excel';
      $config['allowed_types'] = 'xls|csv';
      $this->load->library('upload',$config);
      // if( !empty($this->input->post('filupload'))){
      if (!$this->upload->do_upload('fileupload')) {

        $error = array('error'=>$this->upload_display_errors());
         $output = '';
         $layout = new Layout();
                $layout->set_title("Gestion des objets client");
                $layout->view("sections/importation", $output, 'admin_page');
        # code...
      }
      else{
         $data = $this->upload->data();
        $this->load->library('spreadsheet_excel_reader');
        $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
        $this->spreadsheet_excel_reader->read($data['full_path']);
        error_reporting(E_ALL ^ E_NOTICE);
        $sheets =  $this->spreadsheet_excel_reader->sheets[0];
        $data_excel = array();
        for ($i = 1; $i <= $sheets['numRows']; $i++) {
          if ($sheets['cells'][$i][1]=='') {
            break;
            # code...
          }
          $data_excel[$i - 1]['user'] = $sheets['cells'][$i][1];
           $data_excel[$i - 1]['client_id'] = $sheets['cells'][$i][2];
            $data_excel[$i - 1]['objet'] = $sheets['cells'][$i][3];
            $data_excel[$i - 1]['nom_objet'] = $sheets['cells'][$i][4];
            $data_excel[$i - 1]['naissance_objet'] = $sheets['cells'][$i][5];
            $data_excel[$i - 1]['race_objet'] = $sheets['cells'][$i][6];
            $data_excel[$i - 1]['veterinaire'] = $sheets['cells'][$i][7];
            $data_excel[$i - 1]['sport_canin'] = $sheets['cells'][$i][8];
            $data_excel[$i - 1]['commentaire'] = $sheets['cells'][$i][9];
        }
        // print_r($data_excel);die();
        $data = array();
        for ($i=0; $i < sizeof($data_excel); $i++) { 
          // $data[$i]['user'] = $data_excel[$i]['user'];
          $data[$i]['client_id'] = $data_excel[$i]['client_id'];
          // $data[$i]['client_id'] = 8;
          // $data[$i]['object_id'] = 1;
          $data[$i]['dynamic_fields'] = '{"1":"'.$data_excel[$i]["nom_objet"].'","2":"'.$data_excel[$i]["naissance_objet"].'","3":"'.$data_excel[$i]["race_objet"].'","4":"'.$data_excel[$i]["veterinaire"].'","5":"'.$data_excel[$i]["sport_canin"].'","6":"'.$data_excel[$i]["commentaire"].'"}';
        }
        // $data[1]['Objet_dy'] = 'toto';
        // {"1":"toutou","2":"2016-06-01","3":"156","4":"","5":"","6":""}

         // print_r($data);die();
        $this->load->model('upload');
        $this->upload->insert_upload_file($data);
    
        // $data = array('upload_data'=>$this->upload->data());
         $layout = new Layout();
      $output ="";
      $layout->set_title("importation success");
      $layout->view("sections/importation", $output, 'admin_page');
      }
     
    }
    // }
}
