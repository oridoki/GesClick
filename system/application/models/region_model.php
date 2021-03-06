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

class region_model extends Model {

	private $id;
	private $country_id;
	private $name;
	
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }

	public function getlist($id_region, $id_idioma) {
		
		$this->db->select('id, nombre');
		$this->db->from('regiones');
		$this->db->where('id_idioma', $id_idioma);
		$this->db->where('id_pais', $id_region);

		$query = $this->db->get();
		return $query->result_array();
		
		
	}

	
}