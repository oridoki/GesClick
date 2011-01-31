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

class tax_model extends Model {

	private $id;
	private $name;
	private $value;
		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }
	
	public function getList($u_id) {
		
		$this->db->select('*');
		$this->db->from('tax');
		
		$this->db->where('user_id', $u_id);
		
		$query = $this->db->get();
		return $query->result_array();		
		
	}

	public function add($data) {

		$this->db->insert('tax', $data);

		return $this->db->insert_id();
		
	}
	
	public function update($t_id, $data) {
		
        $this->db->update('tax', $data, array('id' => $t_id));
		
	}
	
	public function delete($t_id, $u_id) {

		if($this->exists($t_id, $u_id)) {
			$this->db->where('id', $t_id);
			$this->db->delete('tax');
		}
		
	}
	
	public function exists($t_id, $u_id) {

		$this->db->select('count(*) cuants');
		$this->db->from('tax');
		
		$this->db->where('user_id', $u_id);
		$this->db->where('id', $t_id);
		
		$query = $this->db->get();
		$res = $query->result_array();

		if($res[0]['cuants'] == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	}

	public function defaults() {
		
		$this->tax_model->add(array(
			'user_id'		=> $this->db_session->userdata(AUTH_SECURITY_USER_ID),
			'name' 			=> 'IVA 18%',
			'value' 		=> '18'
		));
		$this->tax_model->add(array(
			'user_id'		=> $this->db_session->userdata(AUTH_SECURITY_USER_ID),
			'name' 			=> 'IVA 8%',
			'value' 		=> '8'
		));
		$this->tax_model->add(array(
			'user_id'		=> $this->db_session->userdata(AUTH_SECURITY_USER_ID),
			'name' 			=> 'IVA 4%',
			'value' 		=> '4'
		));
		
	}
	


}

?>