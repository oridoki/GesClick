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

class task_model extends Model {

    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getList($user_id) {

		$this->db->select('task.*');
		$this->db->select('DATE_FORMAT(task.date, " %d / %m / %Y") as date', false);
		$this->db->select('DATE_FORMAT(task.date, " %H:%i") as time', false);
		$this->db->select('company.color as company_color');

		$this->db->from('task');
		$this->db->join('user2company', 'user2company.company_id = task.company_id');
		$this->db->join('company', 'user2company.company_id = company.id');

		$this->db->where('user2company.user_id', $user_id);
		
		$this->db->order_by("task.date");
		
		$query = $this->db->get();
		return $query->result_array();

	}
	
	public function add($data) {
		
		$this->db->insert('task', $data);

		return $this->db->insert_id();
		
	}

	public function update($data, $t_id) {

        $this->db->update('task', $data, array('id' => $t_id));
		
	}
	
	public function delete($t_id, $u_id) {

		if($this->exists($t_id, $u_id)) {
			$this->db->where('id', $t_id);
			$this->db->delete('task');
		}
		
	}
	
	public function exists($t_id, $u_id) {

		$this->db->select('count(*) cuants');
		$this->db->from('task');

		$this->db->join('user2company', 'user2company.company_id = task.company_id');

		$this->db->where('user2company.user_id', $u_id);
		$this->db->where('task.id', $t_id);
		
		$query = $this->db->get();
		$res = $query->result_array();

		if($res[0]['cuants'] == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	}
}