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

class contact extends Controller {
	
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

	
	public function index() {

		$this->load->model("contact_model");
		$data['contacts'] = $this->contact_model->getList($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		

		$this->layouts($this->load->view("contact/list", $data, true));
		
	}

	
	public function edit($contact_id) {
			
		$this->load->model('customer_model');
		if($this->customer_model->exists($_POST['customer_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {

			$this->load->model("contact_model");

			$data = array(
				'customer_id'	=> $_POST['customer_id'],
				'name' 			=> $_POST['name'],
				'surname' 		=> $_POST['surname'],
				'phone1' 		=> $_POST['phone1'],
				'phone2' 		=> $_POST['phone2'],
				'email1' 		=> $_POST['email']
			);


			// ................................. UPDATE
			if($this->contact_model->exists( $contact_id,  $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
				$this->contact_model->update($contact_id, $data);
				$data['id'] = $contact_id;
			// ................................. ADD
			} else {
				$this->load->model("contact_model");
				$data['id'] = $this->contact_model->add($data);
			}			
			
		}

		$this->load->view("contact/p_line", array('contact' => $data), false);

	}


	public function delete($contact_id) {
		
		if(isset($contact_id)) {
			$this->load->model('contact_model');
			$this->contact_model->delete($contact_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		}
		
	}

}

?>
