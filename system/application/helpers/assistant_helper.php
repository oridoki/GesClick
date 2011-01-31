<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function needsAssistance($assistance) {
	
	while (list($clau, $valor) = each($assistance)) {
		if($valor) {
			return true;
		}
	}
	return false;
	
}

function checkAssistance() {

	$result = array(
		'companies' => 0,
		'customers' => 0
	);
    $obj =& get_instance();

	// Si no ha creat cap empresa
	$obj->load->model("company_model");
	$companies = $obj->company_model->getCompanies($obj->db_session->userdata(AUTH_SECURITY_USER_ID));
	if(count($companies) == 0) {
		$result['companies'] = 1;
	}
	
	// Si no ha creat cap client
	$obj->load->model("customer_model");
	
	if($obj->customer_model->cuants($obj->db_session->userdata(AUTH_SECURITY_USER_ID)) == 0) {
		$result['customers'] = 1;
	}
	
	return $result;

}





?>