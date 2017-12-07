<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Object extends Back {

    public function index() {

        $client_id = (int) $this->uri->segment(4);
		
        if ($client_id > 0) {
            $crud = new grocery_CRUD();
            $crud->set_theme('flexigrid');
            $crud->set_table('client_object_entities');
            $crud->set_subject('Chien');
            $crud->where('object_id = 1 AND client_id = ' . $client_id); // 1 => entité chien
            $crud->columns('nom_chien'); // 1 => entité chien

            $crud->display_as(array(
                'nom_chien' => 'Nom du chien',
                'client_id' => 'Client',
                'object_id' => 'Chien',
                'dynamic_fields' => 'Informations'
            ));
            $crud->field_type('object_id', 'hidden', 1);
            $crud->field_type('client_id', 'hidden', $client_id);

            $crud->callback_column('nom_chien', array($this, 'callbak_entity_title'));
            $crud->callback_field('dynamic_fields', array($this, 'callback_load_dynamic_fields'));
            $crud->callback_read_field('dynamic_fields', array($this, 'callback_load_dynamic_fields'));
            $crud->callback_before_insert(array($this, 'callback_format_dynamic_fields'));
            $crud->callback_before_update(array($this, 'callback_format_dynamic_fields'));

            $user_model = new User_model();
            $logged_user = $user_model->get_user_by_uid($this->oc_auth->get_user_id());
            if (!$logged_user->use_excel) {
                //$crud->unset_export();
            }
            $output = $crud->render();
        }

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        if (isset($this->_alertes) && !empty($this->_alertes)) {
            $output->alertes = $this->_alertes;
        }
        if (isset($this->_user) && !empty($this->_user)) {
            $output->user = $this->_user;
        }

        $layout = new Layout();
        $layout->set_title("Chiens");
        $layout->view("sections/client_object", $output, 'iframe_page');
    }

    function callbak_entity_title($value, $row) {
        $this->load->model('Client_model');
        $client_model = new Client_model();

        $object = $client_model->get_object_by_id($row->entity_id);
        if (!empty($object) && isset($object->dynamic_fields) && !empty($object->dynamic_fields)) {
            $dynamic_fields = json_decode($object->dynamic_fields, true);
            return !empty($dynamic_fields[1]) ? $dynamic_fields[1] : 'Non défini';
        } else {
            return 'Non défini';
        }
    }

    function callback_load_dynamic_fields($post_array, $primary_key) {
        $this->load->model('Client_model');
        $client_model = new Client_model();
        $object_fields = $client_model->get_client_object_fields_by_object_id(1); // 1 => chien
		
		
	
        $input = '';
        $counter = 0;
        $dynamic_fields = array();

        $object_id = (int) $this->uri->segment(6);
		
        if ($object_id > 0) {
            $object = $client_model->get_object_by_id($object_id);
			
			
            if (!empty($object) && isset($object->dynamic_fields) && !empty($object->dynamic_fields)) {
                $dynamic_fields = json_decode($object->dynamic_fields, true);
				
				
            }
        }
	
        foreach ($object_fields AS $item) {
            $row_style = ($counter % 2 == 0) ? ' odd' : ' even';
            if (!empty($item->label)) {
                $input .= '<div class="form-field-box' . $row_style . '">';
				
				 if ($item->field_type == 'boolean') {
                   $input .= '<div class="form-display-as-box">' . $item->label . '</div>';
                    $input .= '<div class="form-input-box">';
                    if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 1)) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $input .= '    <div class="switch">';
                    $input .= '        <input class="switch-input oui_selection" id="field_' . $item->field_id . '_true" name="field_' . $item->field_id . '" type="radio" value="1"' . $checked . '/>';
                    $input .= '        <label for="field_' . $item->field_id . '_true" class="switch-label switch-label-off">oui</label>';
                    if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 0)) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $input .= '        <input class="switch-input non_selection" id="field_' . $item->field_id . '_false" name="field_' . $item->field_id . '" type="radio" value="0"' . $checked . '/>';
                    $input .= '        <label for="field_' . $item->field_id . '_false" class="switch-label switch-label-on">non</label>';
                    $input .= '        <span class="switch-selection"></span>';
                    $input .= '    </div>';
                    $input .= '</div>';
                    $input .= '<div class="clear"></div>';
					
					/*
					$input .= '<div class="form-field-box' . $row_style . '">';
					$input .= '<div class="form-display-as-box">' . $item->label . '</div>';
					$input .= '<div class="form-input-box">';
					$input .= '<div class="switch">
								<input class="switch-input" id="field_' . $item->field_id . '_true" name="field_' . $item->field_id . '" value="1" type="radio">
								<label for="field_' . $item->field_id . '_true" class="switch-label switch-label-off">oui</label>
								<input class="switch-input" id="field_' . $item->field_id . '_false" name="field_' . $item->field_id . '" value="0" checked="checked" type="radio">
								<label for="field_' . $item->field_id . '_false" class="switch-label switch-label-on">non</label>
								<span class="switch-selection"></span>
							</div>';
					$input .= '</div>';
					$input .= '</div>';
					$input .= '<div class="clear"></div>';
					
					*/
                }
				
				
				
				
				
				
                else if ($item->field_type == 'booledan') {
                    $input .= '<div class="form-display-as-box">' . $item->label . '</div>';
                    $input .= '<div class="form-input-box">';
                    $input .= '    <div class="pretty-radio-buttons">';
                    if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 1)) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $input .= '        <div class="radio">';
                    $input .= '            <input id="field_' . $item->field_id . '_true" name="field_' . $item->field_id . '" type="radio" value="1"' . $checked . '/>&nbsp;<label for="field_' . $item->field_id . '_true">oui</label>';
                    $input .= '        </div>';
                    if ((isset($dynamic_fields[$item->field_id]) && intval($dynamic_fields[$item->field_id]) == 0)) {
                        $checked = ' checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $input .= '        <div class="radio">';
                    $input .= '            <input id="field_' . $item->field_id . '_false" name="field_' . $item->field_id . '" type="radio" value="0"' . $checked . '/>&nbsp;<label for="field_' . $item->field_id . '_false">non</label>';
                    $input .= '        </div>';
                    $input .= '    </div>';
                    $input .= '</div>';
                    $input .= '<div class="clear"></div>';
                } elseif ($item->field_type == 'dropdown') {
                    $input .= '<div>';
                    $input .= '   <label for="field_' . $item->field_id . '">' . $item->label . '</label><select class="change_select name="field_' . $item->field_id . '" id="field_' . $item->field_id . '">';
                    $field_options = $client_model->get_client_object_field_options($item->field_id);
                    $dropdown = array();
                    $input .= '       <option value="">-- choisir --</option>';
					
					$input .= '       <option value="0">Autre </option>';
                    foreach ($field_options AS $option) {
                        if (isset($dynamic_fields[$item->field_id]) && $dynamic_fields[$item->field_id] == $option->option_id) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $dropdown[$option->option_id] = $option->option_value;
                        $input .= '   <option value="' . $option->option_id . '"' . $selected . '>' . $option->option_value . '</option>';
                    }
                    $input .= '    </select>';
                    $input .= '</div>';
					
					
					$input .= '<div id="autre_id" style="display:none;"><label for="autre">Autres</label><input type="text" class="form-control"></div>';
				
					
					
                } elseif ($item->field_type == 'long') {
                    if ((isset($dynamic_fields[$item->field_id]))) {
                        $value = $dynamic_fields[$item->field_id];
                    } else {
                        $value = '';
                    }
                    $input .= '<div style="overflow: hidden;min-height: 360px;"><label for="field_' . $item->field_id . '">' . $item->label . '</label><textarea id="field_' . $item->field_id . '" name="field_' . $item->field_id . '" class="texteditor">' . $value . '</textarea></div>';
                } else {
                    if ((isset($dynamic_fields[$item->field_id]))) {
                        $value = $dynamic_fields[$item->field_id];
                    } else {
                        $value = '';
                    }
					
					
					
					
					
					
					
					
					
					
                    $input .= '<div><label for="field_' . $item->field_id . '">' . $item->label . '</label><input ' . ($item->field_type == 'date' ? ' class="picker datetime-input form-control" placeholder="YYYY-MM-DD" ' : '') . 'id="field_' . $item->field_id . '" name="field_' . $item->field_id . '" type="text" value="' . $value . '"/></div>';
                }
				
				
				
				
                $input .= '</div>';
            }
            $counter++;
        }
        return $input;
    }

    function callback_format_dynamic_fields($post_array) {
        $this->load->model('Client_model');
        $client_model = new Client_model();
        $dynamic_fields = array();

        $object_fields = $client_model->get_client_object_fields_by_object_id(1); // 1 => chien

        foreach ($object_fields AS $item) {
            $dynamic_fields[$item->field_id] = $post_array['field_' . $item->field_id];
            unset($post_array['field_' . $item->field_id]);
        }

        $post_array['dynamic_fields'] = json_encode($dynamic_fields);

        return $post_array;
    }

}
