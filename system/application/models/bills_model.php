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

class bills_model extends Model {

	private $id;
	private $company_id;
	private $customer_id;
	private $number;
	private $date;
	private $due_date;
	private $late_fees_rate;
	private $payment_method;
	private $tags;
	private $notes;
		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function add($data) {

		$this->db->insert('bill', $data);
		return  $this->db->insert_id();
		
	}

	public function update($data, $b_id, $u_id) {

		if($this->exists($b_id, $u_id)) {
	        $this->db->update('bill', $data, array('id' => $b_id));
		}

	}

	public function details($bill_id, $user_id) {
		
		$this->db->select('bill.*');
		$this->db->select('billtype.name bill_name');
		$this->db->select('DATE_FORMAT(bill.date, " %d / %m / %Y") as date', false);
		$this->db->select('DATE_FORMAT(bill.due_date, " %d / %m / %Y") as due_date', false);

		$this->db->from('bill');
		$this->db->join('user2company', 'user2company.company_id = bill.company_id');
		$this->db->join('billtype', 'bill.type_id = billtype.id');
		
		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('bill.id', $bill_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		
		
		if(count($res) > 0) {
			return $res[0];
		} else {
			return false;
		}
		
	}

	public function lista($user, $num, $offset, $type=1) {
		
		$this->db->select('bill.*');
		$this->db->select('company.color');
		$this->db->select('customer.first_name, customer.last_name');

		$this->db->from('bill');
		$this->db->join('customer', 'customer.id = bill.customer_id');
		$this->db->join('company', 'bill.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = bill.company_id');
		
		$this->db->where('user2company.user_id', $user);
		$this->db->where('bill.type_id', $type);
		$this->db->limit($num, $offset);

		$this->db->order_by("date desc, number desc"); 
		
		$query = $this->db->get();
		return $query->result_array();

	}

	public function cuants($user, $type = 1) {
		
		$this->db->select('count(*) as cuants');

		$this->db->from('bill');
		$this->db->join('customer', 'customer.id = bill.customer_id');
		$this->db->join('user2company', 'user2company.company_id = bill.company_id');
		
		$this->db->where('user2company.user_id', $user);
		$this->db->where('bill.type_id', $type);
		
		$query = $this->db->get();
		$v = $query->result_array();
		return $v[0]['cuants'];

	}

	public function list_by_customer($c_id) {
		
		$this->db->select('bill.*');
		$this->db->select('company.color');
		$this->db->select('customer.first_name, customer.last_name');

		$this->db->from('bill');
		$this->db->join('customer', 'customer.id = bill.customer_id');
		$this->db->join('company', 'bill.company_id = company.id');
		
		$this->db->where('customer.id', $c_id);
		
		$query = $this->db->get();
		return $query->result_array();

	}

	public function exists($bill_id, $user_id) {
		
		$this->db->select('bill.id');

		$this->db->from('bill');
		$this->db->join('user2company', 'bill.company_id = user2company.company_id');

		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('bill.id', $bill_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		
				
		if(count($res) > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function delete($bill_id, $user_id) {
		
		if($this->exists($bill_id, $user_id)) {
			// First we need to delete de budgets
			$this->db->where('bill_id', $bill_id);
			$this->db->delete('budget');
			
			// Delete the bill
			$this->db->where('id', $bill_id);
			$this->db->delete('bill');
		}
		
	}
	
	public function search($string, $user_id) {
		
		$this->db->select('bill.*');
		$this->db->select('company.color');
		$this->db->select('customer.first_name');
		$this->db->select('customer.last_name');
		$this->db->select('billtype.name as tipus');
		

		$this->db->from('bill');
		$this->db->join('user2company', 'bill.company_id = user2company.company_id');
		$this->db->join('company', 'bill.company_id = company.id');
		$this->db->join('budget', 'bill.id = budget.bill_id');
		$this->db->join('customer', 'bill.customer_id = customer.id');
		$this->db->join('billtype', 'bill.type_id = billtype.id');

		$this->db->where('user2company.user_id', $user_id);

		$this->db->like('budget.description', $string);
		$this->db->or_like('bill.number', $string);
				
		$this->db->group_by("bill.id"); 
		$this->db->order_by("bill.type_id ASC"); 
		
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	public function getPeriodicBills() {
		
		$this->db->select('bill.*');
		$this->db->select('DATE_FORMAT(bill.date, " %d / %m / %Y") as date', false);

		$this->db->from('bill');
		$this->db->where('bill.recurrences > ', '0');
		$this->db->where('bill.periodicity > ', '0');
		
		$query = $this->db->get();
		return $query->result_array();		
	}
	
}