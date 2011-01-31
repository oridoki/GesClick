<?php
/***
* 
* Copyright 2011 Adrià Cidre Jugo
* 
* This program is free software; you can redistribute it and/or modify 
* it under the terms of the GNU General Public License as published by 
* the Free Software Foundation; either version 2 of the License, or (
* at your option) any later version. This program is distributed in the 
* hope that it will be useful, but WITHOUT ANY WARRANTY; without even 
* the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
* PURPOSE. See the GNU General Public License for more details. You 
* should have received a copy of the GNU General Public License along 
* with this program; if not, write to the Free Software Foundation, 
* Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.
* 
* 
**/

class company extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		if(!$this->authlib->isValidUser()) {
			redirect('/auth/login', 'redirect');
		}

	}


	private function layouts($data) {
		
 		$this->load->view("layouts/admin", array(
			'content' => $data
		));

 	}

	public function delete() {

		if($this->uri->segment(3, 0)) {
			$this->load->model("company_model");
			$this->company_model->delete($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		}
		redirect("/config/index", 'redirect');
		
	}

	
	public function add() {
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('validation');

		// RULES
		$rules['name']			 = "required";
		$rules['vat_number']	 = "required";
		$rules['email']			 = "trim|valid_email";
		$this->validation->set_rules($rules);
		

		// REPOPULATING
		while (list($key, $value) = each($_POST)){
			$fields[$key] = "";
		}

		$fields['name'] 		= 'Nombre/Razón Social';
		$fields['vat_number']	= 'NIF / CIF';
		$fields['email'] 		= 'Correo electrónico';
		$this->validation->set_fields($fields);

		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($this->validation->run() == FALSE) {

			$data['company_id'] = 0;

			// SI ESTAMOS EDITANDO
			if($this->uri->segment(3, 0)) {
				
				$data['company_id'] = $this->uri->segment(3, 0);

				$this->load->model("serie_model");
				$data['series'] = $this->serie_model->getList($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));

				$this->load->model("company_model");
				$company = $this->company_model->details($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				while (list($key, $value) = each($company)){
					$this->validation->{$key} = $value;
				}
				
			}

			$this->load->model("country_model");
			$this->load->model("region_model");
			
			$data['countries'] = $this->country_model->getlist(7);
			$data['regions'] = $this->region_model->getlist(28, 7);
			
			$this->layouts($this->load->view("company/add", $data, true));

		} else { // .............................................................. PROCESSING REQUEST

			reset($_POST);
			while (list($key, $value) = each($_POST)){
				$data[str_replace("contact_", "", $key)] = $value;
			}

			$this->load->model("company_model");

			if(isset($_POST['id'])) { 		//........................... EDITING

				$company_id = $_POST['id'];

				if($this->company_model->exists($_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
					$this->company_model->update($data, $_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				} else {
					echo "El cliente no existe";
					die();
				}

			} else {						//........................... ADDING

				$company_id = $this->company_model->add($data, $this->db_session->userdata(AUTH_SECURITY_USER_ID));

			}

			$config['upload_path'] 		= './uploads/';
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['max_size']			= '100';
			$config['max_width']  		= '1024';
			$config['max_height']  		= '768';
			$config['file_name'] 		= $company_id;
			$config['overwrite'] 		= TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('company_logo')) {
				$image = $this->upload->data();
				$this->company_model->update(array(
					'company_logo' => '/uploads/'.$company_id.$image['file_ext']
				), $company_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));

			}
				

			redirect("/config/", 'redirect');

		}

		
	}


}

?>