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

class cron extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		// Miramos que lo esté llamando el fichero del cron
//		if($_SERVER['SCRIPT_FILENAME'] != 'mailing.php') exit;
	}

	private function sendDue() {
		
		// PAYMENT EMAIL: Buscamos los pagos que vencen hoy
		$this->load->model("usermodel");
		$this->load->model("company_model");
		$this->load->model("payment_model");

		$users = $this->usermodel->getUserList();

		foreach($users as $user) {

			$companies = $this->company_model->getCompanies($user['id']);
			if(count($companies) > 0) {
				$sw = 0;
				for($i=0; $i<count($companies); $i++) {
					$companies[$i]['payments'] = $this->payment_model->getVencidos($companies[$i]['id']);
					if(count($companies[$i]['payments']) > 0){
						$sw = 1;
					}
				}
				if($sw == 1) {
					$body = $this->load->view("email/due", array('companies' => $companies), true);

					$this->load->library('email');
					$this->email->initialize(array(
						'mailtype' 	=> 'html',
						'charset' 	=> 'utf-8',
						'wordwrap' 	=> TRUE
					));

					$this->email->from('info@gesclick.com', 'GesClick');
					$this->email->to($user['email']);
					$this->email->subject(_("Resumen de Deuda Acumulada"));
					$this->email->message($body);
					if(! $this->email->send()) {
						echo "Se ha producido un error";
						echo $this->email->print_debugger();		
					}
				}
			}

		}
		
	}

	private function setVencidos() {
		
		$this->load->model("payment_model");
		$this->payment_model->setVencidos();
		

	}

	public function recurrentBills() {
		
		$this->load->model("bills_model");
		$bills = $this->bills_model->getPeriodicBills();

		foreach($bills as $bill) {

			if($this->bill2renovation($bill)) {
//				$this->bills_model->();
				echo "Has to renovate";
			}
			
		}
		die();	
		
	}
	
	
	private function bill2renovation($bill) {

		switch($bill['periodicity']) {
			
			case '4':	// Mensual
				$date = date("j / m / Y", mktime (0, 0, 0, date("n")-1, date("j"), date("Y")));

				if($bill['date'] <= $date) { // Si la data de la factura es igual la de fa 15 dies!

					$bill['id'] = 'NULL';
					$bill['number'] = $this->bills_model->getLastNumber();
					$bill['recurrences'] = ($_POST['recurrences'] - 1);
					$bill_id = $this->bills_model->add($bill);

/*					// damos de alta los diferentes conceptos
					$this->load->model("budget_model");
					foreach($_POST['items'] as $item) {
						$this->budget_model->add($bill_id, $item);
					}
*/

					if($_POST['type_id'] == '1') {  	// Si es una factura redirigimos a la gestión de pagos
						redirect("/payment/index/".$bill_id, 'redirect');
					} else { 							// Sino redirigimos a la vista
						redirect("/bills/view/".$bill_id, 'redirect');
					}		
				}
			break;
			case '8':	// Anual
				$date = date("j / m / Y", mktime (0, 0, 0, date("n"), date("j"), date("Y") - 1));

				if($bill['date'] <= $date) { // Si la data de la factura es igual la de fa 15 dies!

			
				}
			break;
		}

	}
	
	
	public function mailing() {

		$this->setVencidos();
		$this->sendDue();

	}

}