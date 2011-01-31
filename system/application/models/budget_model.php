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

class budget_model extends Model {

	private $id;
	private $bill_id;
		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }
	
	public function add($bill_id, $item) {
		
		if(isset($item['id']) && $item['id']!='0' && $item['id']!='') {

			$this->db->update('budget', array(
				'description'	=> $item['description'],
				'quantity'		=> $item['quantity'],
				'price'			=> $item['price'],
				'discount_rate' => $item['discount_rate']
			), array('id' => $item['id'], 'bill_id' => $bill_id));
			
		} else {

			$this->db->insert('budget', array(
				'bill_id'		=> $bill_id,
				'description'	=> $item['description'],
				'quantity'		=> $item['quantity'],
				'price'			=> $item['price'],
				'discount_rate' => $item['discount_rate']
			));
			
		}
		
	}

	public function getItems($bill_id) {
		
		$this->db->select('*');
		$this->db->from('budget');
		$this->db->where('bill_id', $bill_id);
		
		$query = $this->db->get();
		return $query->result_array();

	}

	public function deleteAllExcept($bill_id, $exceptions) {
		
		$this->db->where('bill_id', $bill_id);
		
		for($i=0;$i<count($exceptions);$i++) {
			$this->db->where('id !=', $exceptions[$i]);
		}

		$this->db->delete('budget');
	}

}

?>