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

class company_model extends Model {

		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getRole($c_id, $u_id) {

		$this->db->select('role');
		$this->db->from('user2company');
		
		$this->db->where('user_id', $u_id);
		$this->db->where('company_id', $c_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		
		
		if(count($res) > 0) {
			return $res[0]['role'];
		} else {
			return 0;
		}
		
	}

	public function getCompanies($u_id) {
		
		$this->db->select('company.*');
		$this->db->from('company');
		$this->db->join('user2company', 'user2company.company_id = company.id');
		
		$this->db->where('user2company.user_id', $u_id);
		
		$query = $this->db->get();
		return $res = $query->result_array();		
		
	}

	public function details($company_id, $user_id) {

		$this->db->select('company.*');
		$this->db->select('regiones.nombre as region');
		$this->db->select('paises.nombre as country');

		$this->db->from('company');

		$this->db->join('regiones', 'regiones.id = company.region_id');
		$this->db->join('paises', 'paises.id = company.country_id');
		$this->db->join('user2company', 'user2company.company_id = company.id');

		$idioma = 7;

		$this->db->where('paises.id_idioma', $idioma);
		$this->db->where('regiones.id_idioma', $idioma);
		$this->db->where('company.id', $company_id);
		$this->db->where('user2company.user_id', $user_id);


		$query = $this->db->get();
		$res = $query->result_array();		

		if(count($res) > 0) {
			return $res[0];
		} else {
			return false;
		}
		
	}
	

	public function update($data, $c_id) {

        $this->db->update('company', $data, array('id' => $c_id));

	}


	public function delete($c_id, $u_id) {

		if($this->exists($c_id, $u_id)) {
			$this->db->where('id', $c_id);
			$this->db->delete('company');
			
		}
		
	}
	
	
	public function add($data, $u_id) {

		$this->db->insert('company', $data);
		$id = $this->db->insert_id();
		$this->db->insert('user2company', array(
			'company_id' 	=> $id,
			'user_id'		=> $u_id
		));

		return $id;
	}
	
	
	public function exists($company_id, $user_id) {
		
		$this->db->select('id');
		$this->db->from('company');
		$this->db->join('user2company', 'user2company.company_id = company.id');

		$this->db->where('user2company.user_id', $user_id);
		$this->db->where('id', $company_id);
		
		$query = $this->db->get();
		$res = $query->result_array();		
		
		if(count($res) > 0) {
			return true;
		} else {
			return false;
		}

	}


}

?>