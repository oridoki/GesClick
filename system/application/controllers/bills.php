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

class bills extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		if(!$this->authlib->isValidUser()) {
			redirect('/auth/login', 'redirect');
		}
		if(needsAssistance(checkAssistance())) {
			redirect('/assistant', 'redirect');
		}

	}


	private function convertPayment($date) {
		
		return $date;
	}

	private function getMySQLDate($date) {

		$d = explode(" / ", $date);

		if(count($d) == 3) {
			$mydate = $d[2]."-".$d[1]."-".$d[0]." 00:00:00";
		} else {
			$mydate = "";
		}

		return $mydate;

	}
	
	private function getTotalPayed($payments) {

		$total = 0;
		foreach($payments as $payment) {

			if($payment['state'] == 2) {
				$total += $payment['amount'];
			}

		}
		return $total;
				
	}
	
	private function getBillingBySerie($bills) {
		
		$name = $value = '';
		$tot = 0;
		if(count($bills) > 0) {
			
			foreach($bills as $bill) {
				$tot += $bill['total'];
				if(!isset($total[$bill['serie']])) {
					$total[$bill['serie']] = $bill['total'];
				} else {
					$total[$bill['serie']] += $bill['total'];
				}
			}

			while (list($key, $val) = each($total)) {
				
				$name .= $key."|";
				$value .= number_format((($val*100)/$tot), 2).",";
			}

		}
		
		return array(
			'name' => substr($name, 0, -1),
			'value' => substr($value, 0, -1)
		);
	}
	
	
	private function layouts($data) {
		
 		$this->load->view("layouts/admin", array(
			'content' => $data
		));

 	}
	
	
	private function viewData($bill_id) {
		
		$data = array();

		$this->load->model("bills_model");
		
		$data['bill'] = $this->bills_model->details($bill_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->load->model("customer_model");
		
		$data['customer'] = $this->customer_model->details($data['bill']['customer_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->load->model("budget_model");
		
		$data['items'] = $this->budget_model->getItems($data['bill']['id']);
		
		$subtotal = $descuento = $impuesto1 = $impuesto2 = $total = 0;
		foreach($data['items'] as $item) {
			$parcial = $item['price'] * $item['quantity'];
			$subtotal 	+= $parcial;
			if($item['discount_rate'] != 0) $descuento 	-= $parcial * (($item['discount_rate']/100)+1);
		}

		$impuesto1 = $subtotal * ($data['bill']['tax1'] / 100);
		$impuesto2 = $subtotal * ($data['bill']['tax2'] / 100);
 		$total = $subtotal + $impuesto1 + $impuesto2 + $descuento;
		$data['subtotal'] = $subtotal;
		$data['descuento'] = $descuento;
		$data['impuesto1'] = $impuesto1;
		$data['impuesto2'] = $impuesto2;
		$data['total'] = $total;
		
		$this->load->model("company_model");
		$data['company'] = $this->company_model->details($data['bill']['company_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		
		return $data;
				
	}
		

	private function getTotal($budgets, $tax1, $tax2) {
		
		$total = $taxes = 0;
		foreach($budgets as $budget) {

			$parcial = ($budget['price'] * $budget['quantity']);
			$parcial -= ($parcial * (($parcial * $budget['discount_rate'])/100));
			$total += $parcial;

		}
		
		if($tax1 != 0) {
			$taxes += $total * ($tax1 / 100);
		}
		if($tax2 != 0) {
			$taxes += $total * ($tax2 / 100);
		}
		$total = $total + $taxes;
		
		return $total;
		
	}
	

	function justbills() {
		
		$this->load->model("bills_model");
		if($this->bills_model->cuants($this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			// PAGINACIÓ
			$this->load->library('pagination');
			$config['per_page'] = '50';
			$config['base_url'] = base_url().'index.php/bills/justbills/';
			$config['total_rows'] = $this->bills_model->cuants($this->db_session->userdata(AUTH_SECURITY_USER_ID));
			$this->pagination->initialize($config);
			// ! PAGINACIÓ


			$data['bills'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), $config['per_page'], $this->uri->segment(3), 1);

			$this->layouts($this->load->view("bills/justbills", $data, true));

		} else {

			// Lanzamos el asistente
			$this->layouts($this->load->view("bills/newonservice", array(), true));
		}
	}
	
	function index() {
		
		$this->load->model("bills_model");

		// Com només es un resum no farem servir la paginació

		if($this->bills_model->cuants($this->db_session->userdata(AUTH_SECURITY_USER_ID))) {

			$data['bills'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), 100, $this->uri->segment(3), 1);
			$data['ppto'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), 25, $this->uri->segment(3), 2);
			$data['albaran'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), 25, $this->uri->segment(3), 3);
			$data['proforma'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), 25, $this->uri->segment(3), 4);
			$this->layouts($this->load->view("bills/list", $data, true));

		} else {

			// Lanzamos el asistente
			$this->layouts($this->load->view("bills/newonservice", array(), true));
		
		}

			
/*
		// PAGINACIÓ
		$this->load->library('pagination');
		$config['per_page'] = '25';
		$config['base_url'] = base_url().'index.php/bills/index/';
		$config['total_rows'] = $this->bills_model->cuants($this->db_session->userdata(AUTH_SECURITY_USER_ID));
		$this->pagination->initialize($config);
		// ! PAGINACIÓ

		if($config['total_rows']) {
	
			$data['bills'] = $this->bills_model->lista($this->db_session->userdata(AUTH_SECURITY_USER_ID), $config['per_page'], $this->uri->segment(3));

			$data['chart'] = $this->getBillingBySerie($data['bills']);

			$this->layouts($this->load->view("bills/list", $data, true));

		} else {

			// Lanzamos el asistente
			$this->layouts($this->load->view("bills/newonservice", array(), true));
			
		}
*/		
	}
	
	
	function add() {
		$data = array();

		$this->load->helper(array('form', 'url'));
		$this->load->library('validation');

		$this->load->model("tax_model");
		$taxes = $this->tax_model->getList($this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$data['tax'][0] = 'Ninguno';

		for($i=0; $i<count($taxes); $i++) {
			$data['tax'][$taxes[$i]['value']] = $taxes[$i]['name'];
		}

		$this->load->model("currency_model");
		$currency = $this->currency_model->getList();

		for($i=0; $i<count($currency); $i++) {
			$data['currency'][$currency[$i]['id']] = $currency[$i]['name'];
		}


		// RULES
		$rules['number']	= "required";
		$rules['date']		= "required";
		$rules['customer_id']	= "required|integer";
		$this->validation->set_rules($rules);
		
		// REPOPULATING
		while (list($key, $value) = each($_POST)){
			$fields[$key] = "";
		}
		$fields['number'] 	= 'Número';
		$fields['date'] 	= 'Fecha';
		$fields['customer_id'] 	= 'Cliente';
		
		$this->validation->set_fields($fields);

		// ERROR DELIMITER
		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		if ($this->validation->run() == FALSE) { //.............................. SHOW THE FORM

			// Carreguem el nom del client
			$this->validation->customer = '';
			$data['items'] = array(array( 'id' => 0, 'bill_id' => 0, 'tax1_id' => 0, 'tax2_id' => 0, 'description' => '', 'quantity' => 0, 'price' => 0, 'discount_rate' => 0 ));
			
			// Carreguem tots els clients
			$this->load->model("customer_model");
			$data['customers'] = $this->customer_model->getlist($this->db_session->userdata(AUTH_SECURITY_USER_ID), 1000, 0);

			$this->load->model('company_model');
			$this->load->model("serie_model");
			$data['companies'] = $this->company_model->getCompanies($this->db_session->userdata(AUTH_SECURITY_USER_ID));
			
			if($this->uri->segment(3, 0)) { //.......................... EDITING

				$this->load->model("bills_model");
				$myBill = $this->bills_model->details($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				while (list($key, $value) = each($myBill)){
					$this->validation->$key = $value;
				}
				$tmp = $this->customer_model->details($this->validation->customer_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				$this->validation->customer = $tmp['first_name']." ".$tmp['last_name'];

				$data['companies'] = array(array('id' => $myBill['company_id'], 'name' => ''));

				$data['series'] = $this->serie_model->getList($myBill['company_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));

				$this->load->model("budget_model");
				$data['items'] = $this->budget_model->getItems($myBill['id']);

			} else { //................................................. ADDING
				$data['series'] = $this->serie_model->getList($data['companies'][0]['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));

				$this->validation->tax1 = 18;
				$this->validation->tax2 = 0;
				if($this->uri->segment(4, 0) == 'type_id') {
					$this->validation->type_id = $this->uri->segment(5, 0);
				}
				if($this->uri->segment(4, 0) == 'customer_id') {
					$this->validation->customer_id = $this->uri->segment(5, 0);
					$this->load->model("customer_model");
					$data['customer'] = $this->customer_model->details($this->uri->segment(5, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
					$this->validation->customer = $data['customer']['first_name']." ".$data['customer']['last_name'];
				}
			}

			$this->layouts($this->load->view("bills/add", $data, true));

		} else { //............................................................... PROCESS THE REQUEST
			
			reset($_POST);
			while (list($key, $value) = each($_POST)){
				$data[$key] = $value;
			}

			$this->load->model("bills_model");

			if(isset($_POST['id'])) { //......................... EDITING

				if($this->bills_model->exists($_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
					$this->bills_model->update(array(
						'company_id' => $_POST['company_id'],
						'customer_id' => $_POST['customer_id'],
						'currency_id' => $_POST['currency_id'],
						'type_id' => $_POST['type_id'],
						'tax1' => $_POST['tax1'],
						'tax2' => $_POST['tax2'],
						'serie' => $_POST['serie'],
						'number' => $_POST['number'],
						'date' => $this->getMySQLDate($_POST['date']),
						'due_date' => $this->getMySQLDate($_POST['due_date']),
						'late_fees_rate' => $_POST['late_fees_rate'],
						'payment_method' => $_POST['payment_method'],
						'tags' => $_POST['tags'],
						'notes' => $_POST['notes'],
						'total' => $this->getTotal($_POST['items'], $_POST['tax1'], $_POST['tax2']),
						'periodicity' => $_POST['periodicity'],
						'recurrences' => $_POST['recurrences'],
						'advance' => $_POST['advance']
					), $_POST['id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));
					
					$this->load->model("budget_model");

					// Borramos los conceptos que ya no existen.
					$myBudgets = array();
					foreach($_POST['items'] as $item) {
						$myBudgets[] = $item['id'].",";
					}
					$this->budget_model->deleteAllExcept($_POST['id'], $myBudgets);

					// damos de alta los diferentes conceptos
					foreach($_POST['items'] as $item) {
						$this->budget_model->add($_POST['id'], $item);
					}
					
					
				} else {
					echo "La factura no existe";
					die();
				}

				redirect("/bills/view/".$_POST['id'], 'redirect');

			} else { //........................................ ADDING
				
				$bill_id = $this->bills_model->add(array(
					'company_id' => $_POST['company_id'],
					'customer_id' => $_POST['customer_id'],
					'currency_id' => $_POST['currency_id'],
					'type_id' => $_POST['type_id'],
					'tax1' => $_POST['tax1'],
					'tax2' => $_POST['tax2'],
					'serie' => $_POST['serie'],
					'number' => $_POST['number'],
					'date' => $this->getMySQLDate($_POST['date']),
					'due_date' => $this->getMySQLDate($_POST['due_date']),
					'late_fees_rate' => $_POST['late_fees_rate'],
					'payment_method' => $_POST['payment_method'],
					'tags' => $_POST['tags'],
					'notes' => $_POST['notes'],
					'total' => $this->getTotal($_POST['items'], $_POST['tax1'], $_POST['tax2']),
					'periodicity' => $_POST['periodicity'],
					'recurrences' => $_POST['recurrences'],
					'advance' => $_POST['advance']
				));

				// damos de alta los diferentes conceptos
				$this->load->model("budget_model");
				foreach($_POST['items'] as $item) {
					$this->budget_model->add($bill_id, $item);
				}

				
				if($_POST['type_id'] == '1') {  	// Si es una factura redirigimos a la gestión de pagos
					redirect("/payment/index/".$bill_id, 'redirect');
				} else { 							// Sino redirigimos a la vista
					redirect("/bills/view/".$bill_id, 'redirect');
				}
			}


		}



	}
	
	
	public function view() {

		$data = $this->viewData($this->uri->segment(3, 0));

		$this->load->model('payment_model');
		$payments = $this->payment_model->getList($this->uri->segment(3, 0));
		
		$stateName = array(
			0 => 'Programado',
			1 => 'Vencido',
			2 => 'Pagado',
			3 => 'Descartado'
		);
		
		for($i=0;$i<count($payments);$i++) {
			$payments[$i]['date'] = $payments[$i]['date'];
			$payments[$i]['stateName'] = $stateName[$payments[$i]['state']];
		}
		
		$data['payments'] = $payments;
		$data['payed'] = $this->getTotalPayed($payments);
		
		$this->load->model("shipping_model");
		$data['shipping'] = $this->shipping_model->getList($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		
		$this->layouts($this->load->view("bills/view", $data, true));
		
	}


	public function prnt() {
		
		// page info here, db calls, etc.     

		$data = $this->viewData($this->uri->segment(3, 0));

		switch($this->uri->segment(4, 0)) {
			case "pdf":
//				$this->load->view("bills/pdf", $data, false);

				$data['print'] = 0;

				$this->load->plugin('to_pdf');
			     // page info here, db calls, etc.     
			     $html = $this->load->view('bills/pdf', $data, true);
			     pdf_create($html, 'filename');				

			break;
			case "html":
				$data['print'] = 1;
				$this->load->view("bills/html", $data, false);
			break;
		}
		
	
	}

	
	public function bymail() {

		// Generamos el fichero
		$data = $this->viewData($this->uri->segment(3, 0));
		$this->load->plugin('to_pdf');
		$html = $this->load->view('bills/pdf', $data, true);
		$file_path = pdf_create($html, 'filename', FALSE);

		// Hacemos la validación de datos
		$to = $_POST['email'];
		$subject = $_POST['subject'];
		$body = $_POST['body'];

		// Obtenemos los datos de la empresa
		$from_email = $data['company']['email'];
		$from_name 	= $data['company']['name'];

		// Hacemos el envio del email
		$this->load->library('email');
		$this->email->from($from_email, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->attach($file_path);

		if(! $this->email->send()) {
			die();
			//echo "Se ha producido un error";
			//echo $this->email->print_debugger();		
		}

		// Borramos el fichero
		unlink($file_path);
		
		// Guardamos los datos en el historico de envios
		$this->load->model("shipping_model");
		$id = $this->shipping_model->add($_POST['bill_id'], $_POST['email'], $_POST['subject'], $_POST['body']);
		
		// Mostramos la linea
		echo $this->load->view("shipping/p_line.php", array('ship' => array(
			'id'			=> $_POST['bill_id'],
			'bill_id'		=> $_POST['bill_id'],
			'email'			=> $_POST['email'],
			'subject'		=> $_POST['subject'],
			'body'			=> $_POST['body'],
			'date'			=> date("d / m / Y")
		)), true);
		
		die();
		
	}


	public function delete() {

		$this->load->model("bills_model");

		if($this->bills_model->exists($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			
			$bill_id = $this->uri->segment(3, 0);
			// Delete Budget
			$this->load->model("budget_model");
			$this->budget_model->deleteAllExcept($bill_id, array());
			
			// Delete Shipping
			$this->load->model("shipping_model");
			$this->shipping_model->deleteByBillId($bill_id);
			
			// Delete Payments
			$this->load->model("payment_model");
			$this->payment_model->deleteByBillId($bill_id);			
			
			// Delete Bill
			$this->bills_model->delete($bill_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));

		}
		
		redirect("/bills/index", 'redirect');

	}
	
	
}

?>