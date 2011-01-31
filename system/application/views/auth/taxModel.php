<?php

class tax_model extends Model {

	private $id;
	private $name;
	private $value;
		
    public function __construct() {

        // Call the Model constructor
        parent::Model();
		$this->db->simple_query("SET NAMES 'utf8'"); 

    }
	
	public function getList() {
		
		$this->db->select('*');
		$this->db->from('tax');
		
		$query = $this->db->get();
		return $query->result_array();		
		
	}

}

?>