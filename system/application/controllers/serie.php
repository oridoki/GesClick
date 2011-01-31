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

class serie extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		if(!$this->authlib->isValidUser()) {
			redirect('/auth/login', 'redirect');
		}

	}


	public function delete() {

		$this->load->model("serie_model");
		if($this->serie_model->exists($this->uri->segment(3, 0), $_POST['c_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			$this->serie_model->delete($this->uri->segment(3, 0));
		}

	}

	public function edit() {

		$this->load->model("serie_model");
		
		if($this->serie_model->exists($this->uri->segment(3, 0), $_POST['c_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			$this->serie_model->update($this->uri->segment(3, 0), array(
				'prefix' 		=> $_POST['title'],
				'description' 	=> $_POST['body']
			));
		} else {
			$this->load->model("company_model");
			if($this->company_model->exists($_POST['c_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
				$data['serie']['id'] = $this->serie_model->add(array(
					'company_id'	=> $_POST['c_id'],
					'prefix' 		=> $_POST['title'],
					'description' 	=> $_POST['body']
				));
				$data['serie']['company_id']	= $_POST['c_id'];
				$data['serie']['prefix'] 		= $_POST['title'];
				$data['serie']['description'] 	= $_POST['body'];

				$this->load->view("serie/line", $data, false);
			}
		}

	}

	public function jsonlist() {
		
		$json = array();
		$this->load->model("serie_model");
		$json = $this->serie_model->getList($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		echo json_encode($json);
		
	}


}

?>