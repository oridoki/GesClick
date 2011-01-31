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

class assistant extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		if(!$this->authlib->isValidUser()) {
			redirect('/auth/login', 'redirect');
		}

	}	
	
	private function layouts($data) {
		
 		$this->load->view("layouts/assistant", array(
			'content' => $data
		));

 	}

	public function index() {

		$assist = checkAssistance();

		if(needsAssistance($assist)) {
			$this->layouts($this->load->view("assistant/index", array('assist' => $assist), true));
		} else {
			redirect('/bills', 'redirect');
		}
		
	}

}

?>