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

class shipping_model extends Model {

    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function add($bill_id, $email, $subject, $body) {
		
		$this->db->insert('shipping', array(
			'bill_id'		=> $bill_id,
			'email'			=> $email,
			'subject'		=> $subject,
			'body'			=> $body
		));
		
		return  $this->db->insert_id();
		
	}
	

	public function getlist($bill_id, $user_id) {
		
		$this->db->select('shipping.*');
		$this->db->select('DATE_FORMAT(shipping.date, " %d / %m / %Y") as date', false);

		$this->db->from('shipping');
		$this->db->join('bill', 'bill.id = shipping.bill_id');
		$this->db->join('user2company', 'bill.company_id = user2company.company_id');

		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('bill_id', $bill_id);
		
		$query = $this->db->get();
		return $query->result_array();
		
	}

	public function deleteByBillId($bill_id) {
		
		$this->db->where('bill_id', $bill_id);
		$this->db->delete('shipping');
		
	}


}

?>