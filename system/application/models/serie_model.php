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

class serie_model extends Model {

		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getList($c_id, $u_id) {
		
		$this->db->select('serie.*');
		$this->db->select_max('bill.number');
		
		$this->db->from('serie');
		$this->db->join('user2company', 'user2company.company_id = serie.company_id');
		$this->db->join('bill', 'bill.serie = serie.prefix AND bill.type_id=1', 'left');
		
		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('serie.company_id', $c_id);
		
		$this->db->group_by('serie.id');
		$this->db->order_by('serie.prefix asc, bill.number asc');

		$query = $this->db->get();
		$res = $query->result_array();

		return $res;

	}
	
	public function add($data) {

		$this->db->insert('serie', $data);

		return $this->db->insert_id();
		
	}
	
	public function update($s_id, $data) {
		
        $this->db->update('serie', $data, array('id' => $s_id));
		
	}
	
	public function delete($s_id) {

		$this->db->where('id', $s_id);
		$this->db->delete('serie');
		
	}
	
	public function exists($s_id, $c_id, $u_id) {

		$this->db->select('count(*) cuants');
		$this->db->from('serie');
		$this->db->join('user2company', 'user2company.company_id = serie.company_id');
		
		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('serie.company_id', $c_id);
		$this->db->where('serie.id', $s_id);
		
		$query = $this->db->get();
		$res = $query->result_array();

		if($res[0]['cuants'] == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	}

}