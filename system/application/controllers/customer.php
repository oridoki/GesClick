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

class customer extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		if(!$this->authlib->isValidUser()) {
			redirect('/auth/login', 'redirect');
		}


	}

	private function layouts($data) {
		
 		$this->load->view("layouts/admin", array(
			'content' => $data
		));

 	}
	
	private function getTotal($bills) {
		
		$total = 0;
		foreach($bills as $bill) {
			$total += $bill['total'];
		}
		return $total;
		
	}
	
	private function getVencida($bills) {

		$total = 0;
		return $total;
		
	}
	
	function index() {
		
		$this->load->model("customer_model");

		// PAGINACIÓ
		$this->load->library('pagination');
		$config['per_page'] = '25';
		$config['base_url'] = base_url().'index.php/customer/index/';
		$config['total_rows'] = $this->customer_model->cuants($this->db_session->userdata(AUTH_SECURITY_USER_ID));
		$this->pagination->initialize($config);
		// ! PAGINACIÓ

		if($config['total_rows']) {
			$data['customers'] = $this->customer_model->getlist($this->db_session->userdata(AUTH_SECURITY_USER_ID), $config['per_page'], $this->uri->segment(3));

			$this->layouts($this->load->view("customer/list", $data, true));
		} else {

			// Lanzamos el asistente
			$this->layouts($this->load->view("customer/newonservice", array(), true));
			
		}
		
	}
	
	function add() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('validation');

		// RULES
		$rules['contact_first_name']	= "required";
		$rules['contact_email']	 = "trim|valid_email";
		
		
		// $rules['contact_last_name']	= "required";
		// $rules['username']	= "trim|required|min_length[5]|max_length[12]|xss_clean";
		$this->validation->set_rules($rules);
		
		// REPOPULATING
		while (list($key, $value) = each($_POST)){
			$fields[$key] = "";
		}

		$fields['contact_first_name'] = 'Nombre/Razón Social';
		$fields['contact_email'] = 'Correo electrónico';
		$this->validation->set_fields($fields);

		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($this->validation->run() == FALSE) {

			// Si estamos editando el producto
			if($this->uri->segment(3, 0)) {

				$this->load->model("customer_model");
				$myCustmer = $this->customer_model->details($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				while (list($key, $value) = each($myCustmer)){
					$this->validation->{"contact_".$key} = $value;
				}
			}

			$this->load->model("country_model");
			$this->load->model("region_model");
			$this->load->model("company_model");
			
			$data['countries'] = $this->country_model->getlist(7);
			$data['regions'] = $this->region_model->getlist(28, 7);
			$data['companies'] = $this->company_model->getCompanies($this->db_session->userdata(AUTH_SECURITY_USER_ID));
			
			$this->layouts($this->load->view("customer/add", $data, true));

		} else {

			reset($_POST);
			while (list($key, $value) = each($_POST)){
				$data[str_replace("contact_", "", $key)] = $value;
			}

			$this->load->model("customer_model");

			if(isset($_POST['id'])) { 		// Estem fent un update

				if($this->customer_model->exists($_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
					$this->customer_model->update($data, $_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				} else {
					echo "El cliente no existe";
					die();
				}

			} else {						// Estem afegint un nou producte

				$this->customer_model->add($data);

			}

			redirect("/customer/", 'redirect');

		}
	}

	function view() {

		if($this->uri->segment(3, 0)) {

			$this->load->model("customer_model");
			$data['customer'] = $this->customer_model->details($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
			
			$this->load->model('bills_model');
			$data['bills'] = $this->bills_model->list_by_customer($this->uri->segment(3, 0));

			$this->load->model("company_model");

			$this->load->model('contact_model');
			$data['contacts'] = $this->contact_model->getList($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));

			$this->load->model("payment_model");
			$data['payments'] = $this->payment_model->getDueByCustomer($this->uri->segment(3, 0));
			$data['payed'] = '0';
			
			$data['total_1'] = $data['total_2'] = $data['total_3'] = 0;
			foreach($data['payments'] as $payment) {
				$data['total_1'] += $payment['amount'];
				if($payment['state'] == 1) {
					$data['total_2'] += $payment['amount'];
				}
				if($payment['state'] == 0) {
					$data['total_3'] += $payment['amount'];
				}
			}

			$data['total'] = $data['total_facturat'] = number_format($this->getTotal($data['bills']), 2, ",", ".");
		}

		$this->layouts($this->load->view("customer/view", $data, true));

		
	}

	function delete() {

		if($this->uri->segment(3, 0)) {
			$this->load->model("customer_model");
			$this->customer_model->delete($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		}
		redirect("/customer/index", 'redirect');
		
	}

	function ajaxlist() {
		
		$this->load->model("customer_model");
		$result = $this->customer_model->search($this->db_session->userdata(AUTH_SECURITY_USER_ID), $_POST['str']);
		
		echo "[";
		for($i=0;$i<count($result);$i++) {
			echo "{text:'".$result[$i]['first_name']." ".$result[$i]['last_name']."', id:'".$result[$i]['id']."'}";
			if($i < (count($result)-1)) {
				echo ",";
			}
		}
		echo "]";
		
		die();
		
	}

}

?>