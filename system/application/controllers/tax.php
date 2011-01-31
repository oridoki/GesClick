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

class tax extends Controller {
	
    function __construct() {
	
    	parent::Controller();
	}
	
	function delete() {
		
		if($this->uri->segment(3, 0)) {
			$this->load->model('tax_model');
			$this->tax_model->delete($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		}
	
	}

	function edit() {
		
		$this->load->model("tax_model");
		
		if($this->tax_model->exists($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			$this->tax_model->update($this->uri->segment(3, 0), array(
				'name' 		=> $_POST['name'],
				'value' 	=> $_POST['value']
			));
		} else {
			$data['tax']['id'] = $this->tax_model->add(array(
				'user_id'		=> $this->db_session->userdata(AUTH_SECURITY_USER_ID),
				'name' 			=> $_POST['name'],
				'value' 		=> $_POST['value']
			));
			$data['tax']['name'] 		= $_POST['name'];
			$data['tax']['value'] 		= $_POST['value'];

			$this->load->view("tax/line", $data, false);
		}		
		
	}

	
}

?>