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

class customer_model extends Model {

	private $id;
	private $name;
	private $surname;
	private $nif;
	private $ct_name;
	private $ct_address;
	private $ct_cp;
	private $ct_city;
	private $ct_country;
	private $ct_region;
	private $ct_phone1;
	private $ct_phone2;
	private $ct_fax;
	private $ct_email;
	private $ct_web;
	private $e_address;
	private $e_cp;
	private $e_city;
	private $e_country_id;
	private $e_region_id;
	private $e_phone1;
	private $e_phone2;
	private $language_id;
	private $discount;
	private $cc;
	private $comments;

	
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getlist($user_id, $num, $offset) {
		
		$this->db->select('customer.id, customer.first_name, customer.last_name, customer.email, customer.phone1, customer.phone2, customer.bank_account_number');
		$this->db->from('customer');
		$this->db->join('company', 'customer.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = company.id');
		
		$this->db->where('user2company.user_id', $user_id);
		$this->db->limit($num, $offset);
		
		$this->db->order_by("first_name", "asc"); 

		$query = $this->db->get();
		
		return $query->result_array();		
	}

	public function cuants($user_id) {
		
		$this->db->select('count(*) as cuants');
		$this->db->from('customer');
		$this->db->join('company', 'customer.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = company.id');

		$this->db->where('user2company.user_id', $user_id);
		
		$this->db->order_by("first_name", "asc"); 

		return $this->db->count_all_results();
	}


	public function add($data) {

		$this->db->insert('customer', $data);

	}
	
	public function details($customer_id, $user_id) {
		
		$this->db->select('customer.*');
		$this->db->select('regiones.nombre as region');
		$this->db->select('paises.nombre as country');
		
		$this->db->from('customer');
		
		$this->db->join('regiones', 'regiones.id = customer.region_id');
		$this->db->join('paises', 'paises.id = customer.country_id');
		$this->db->join('company', 'customer.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = company.id');
		
		$idioma = 7;
		
		$this->db->where('paises.id_idioma', $idioma);
		$this->db->where('regiones.id_idioma', $idioma);
		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('customer.id', $customer_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		

		if(count($res) > 0) {
			return $res[0];
		} else {
			return false;
		}
		
	}
	
	public function exists($customer_id, $user_id) {
		
		$this->db->select('customer.id');
		$this->db->from('customer');
		$this->db->join('company', 'customer.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = company.id');

		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('customer.id', $customer_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		
		
		if(count($res) > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function update($data, $c_id, $u_id) {

        $this->db->update('customer', $data, array('id' => $c_id));

	}
	
	public function delete($c_id, $u_id) {

		if($this->exists($c_id, $u_id)) {
			$this->db->where('id', $c_id);
			$this->db->delete('customer');
			
		}
		
	}
	
	public function search($user_id, $str) {
		
		$this->db->select('customer.id, customer.first_name, customer.last_name, customer.email, customer.phone1, customer.phone2');
		$this->db->from('customer');
		$this->db->join('company', 'customer.company_id = company.id');
		$this->db->join('user2company', 'user2company.company_id = company.id');

		$this->db->where('user2company.user_id', $user_id);
		$this->db->like('customer.first_name', $str);

		$this->db->order_by("customer.first_name", "asc"); 

		$query = $this->db->get();
//		echo $this->db->last_query();
		return $query->result_array();		
	}
	
}