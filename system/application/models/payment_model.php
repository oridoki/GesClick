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

class payment_model extends Model {
	
	public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }
    

	public function add($data) {

		$this->db->insert('payment', $data);

		return $this->db->insert_id();

	}
	
	public function update($id, $u_id, $data) {

		if($this->exists($id, $u_id)) {
        	$this->db->update('payment', $data, array('id' => $id));
		}
		
	}
	
	public function delete($id, $u_id) {

		if($this->exists($id, $u_id)) {
			$this->db->where('id', $id);
			$this->db->delete('payment');
		}
		
	}
	
	public function getList($b_id) {
		
		$this->db->select('payment.*');
		$this->db->select('DATE_FORMAT(payment.date, " %d / %m / %Y") as date', false);

		$this->db->from('payment');
		$this->db->where('bill_id', $b_id);

		$query = $this->db->get();
		return $query->result_array();
		
	}


	public function exists($id, $u_id) {

		$this->db->select('count(*) cuants');
		$this->db->from('payment');
		$this->db->join('bill', 'bill.id = payment.bill_id');
		$this->db->join('user2company', 'bill.company_id = user2company.company_id');
		
		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('payment.id', $id);
		
		$query = $this->db->get();
		$res = $query->result_array();

		if($res[0]['cuants'] == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	}
	
	public function getDueByUser($u_id, $groupBy=NULL) {
		
		$this->db->select("bill.serie, bill.number, payment.id, payment.amount, payment.bill_id, payment.alias, payment.state, payment.notes");
		$this->db->select('DATE_FORMAT(payment.date, " %d / %m / %Y") as date', false);
		$this->db->select('customer.first_name, customer.last_name');

		$this->db->from("payment");
		$this->db->join('bill', 'bill.id = payment.bill_id');
		$this->db->join('user2company', 'bill.company_id = user2company.company_id');
		$this->db->join('customer', 'customer.id = bill.customer_id');

		$this->db->where("user2company.user_id", $u_id);
		$this->db->where("payment.state <", "2");

		$this->db->order_by('payment.date', 'ASC');
		if($groupBy) {
			$this->db->group_by($groupBy);
		}

		$query = $this->db->get();
		return $query->result_array();

		
	}

	
	public function getDueByCustomer($customer_id) {
		
		$this->db->select("bill.serie, bill.number, payment.id, payment.amount, payment.bill_id, payment.alias, payment.state, payment.notes");
		$this->db->select('DATE_FORMAT(payment.date, " %d / %m / %Y") as date', false);
		$this->db->select('company.color');

		$this->db->from("payment");
		$this->db->join('bill', 'bill.id = payment.bill_id');
		$this->db->join('customer', 'customer.id = bill.customer_id');
		$this->db->join('company', 'bill.company_id = company.id');

		$this->db->where("customer.id", $customer_id);
		$this->db->where("payment.state <", "2");

		$query = $this->db->get();
		return $query->result_array();
		
	}
	

	public function setVencidos() {

        $this->db->update('payment', array('payment.state' => '1'), array(
			'date <' 	=> date("Y-m-d"), 
			'state' 	=> '0'
		));
		
	}

	
	public function getVencidos($company_id) {
		
		$this->db->select('DATE_FORMAT(payment.date, " %d/%m/%Y") as date', false);
		
		$this->db->select("payment.amount, company.email, customer.first_name, customer.last_name");
		$this->db->from('payment');
		$this->db->join('bill', 'bill.id = payment.bill_id');
		$this->db->join('company', 'bill.company_id = company.id');
		$this->db->join('customer', 'customer.id = bill.customer_id');
		
		$this->db->where('company.id', $company_id);
		$this->db->where('payment.state', 1);

		$this->db->order_by('payment.date', 'DESC');
		
		$query = $this->db->get();
		return $query->result_array();
		
	}


	public function deleteByBillId($bill_id) {
		
		$this->db->where('bill_id', $bill_id);
		$this->db->delete('shipping');
		
	}

	
}


?>