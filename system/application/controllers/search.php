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

class search extends Controller {
	
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
	
	


	function bills() {
		
		$this->load->model("bills_model");
		$data['bills'] = $this->bills_model->search($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->layouts($this->load->view("search/list", $data, true));
		
	}


	function customer() {
		
		$this->load->model("customer_model");
		$data['customers'] = $this->customer_model->search($this->db_session->userdata(AUTH_SECURITY_USER_ID), $this->uri->segment(3, 0));

		$this->layouts($this->load->view("search/customer", $data, true));
		
	}

}