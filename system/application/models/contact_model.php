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

class contact_model extends Model {

		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getList($c_id, $u_id) {

		$result = array();

		$this->db->select('contact.*');
		$this->db->from('contact');
		$this->db->join('customer', 'customer.id = contact.customer_id');
		$this->db->join('user2company', 'customer.company_id = user2company.company_id');

		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('customer.id', $c_id);

		$query = $this->db->get();
		$result = $query->result_array();		

		return $result;
		
	}
	
	function exists($c_id, $u_id) {

		$this->db->select('contact.id');

		$this->db->from('contact');
		$this->db->join('customer', 'customer.id = contact.customer_id');
		$this->db->join('user2company', 'customer.company_id = user2company.company_id');

		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('contact.id', $c_id);
		
		$query = $this->db->get();
		$res = $query->result_array();	
				
		if(count($res) > 0) {
			return true;
		} else {
			return false;
		}

	}


	public function update($c_id, $data) {
		
        $this->db->update('contact', $data, array('id' => $c_id));
		
	}

	public function add($data) {

		$this->db->insert('contact', $data);
		return $this->db->insert_id();
		
	}
	
	public function delete($c_id, $u_id) {
		
		if($this->exists($c_id, $u_id)) {
			$this->db->where('id', $c_id);
			$this->db->delete('contact');
		}
		
	}
	
}

?>