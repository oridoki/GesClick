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

class payment extends Controller {
	
    public function __construct() {
	
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

	private function getTotals($payments) {

		$totals = array(
			"0" => 0,
			"1" => 0,
			'global' => 0
		);
		foreach($payments as $payment) {
			$totals[$payment['state']] += $payment['amount'];
			$totals['global'] += $payment['amount'];
		}
		return $totals;

	}
	
	private function getGraph($payments) {
		
		$dies = array();
		$sortida['numdays'] = date('t');

		for($i=1;$i <= $sortida['numdays'];$i++) {
			$dies[] = $i;
		}
		$sortida['label'] = implode(",", $dies);
		for($i=1;$i <= $sortida['numdays'];$i++) {
			$dies[($i-1)] = 0;
		}
		$max = 100;
		foreach($payments as $payment) {
			if($payment['amount'] > $max) {
				$max = $payment['amount'];
			}
			$date = explode(" / ", $payment['date']);
			if($date[1] == date("m")) {
				$dies[(intval($date[0])-1)] += $payment['amount'];
			}
		}

		$sortida['max'] = ceil($max);
		$sortida['value'] = implode(",", $dies);
		
		return $sortida;
	}

	private function getPercents($total) {
		
		$this->load->model('payment_model');
		$payments = $this->payment_model->getDueByUser($this->db_session->userdata(AUTH_SECURITY_USER_ID), 'bill.customer_id');
		$result = array(
			'label' 	=> array(),
			'value' 	=> array()
		);
		foreach($payments as $payment) {
			$result['label'][] = urlencode($payment['first_name']." ".$payment['last_name']);
			$result['value'][] = ($payment['amount'] * 100)/$total;
		}
		
		return $result;
		
	}
	
	private function getMySQLDate($date) {

		$d = explode(" / ", $date);
		return $d[2]."-".$d[1]."-".$d[0]." 00:00:00";

	}
	
	public function delete($payment_id) {

		$this->load->model('payment_model');
		$this->payment_model->delete($payment_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		
	}
	
	public function update($id) {
		
		$this->load->model("bills_model");
		if($this->bills_model->exists($_POST['bill_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) { 

			if($id == 0) {

				$this->load->model('payment_model');

				$data = array(
					'bill_id' 	=> $_POST['bill_id'],
					'date' 		=> $this->getMySQLDate($_POST['date']),
					'amount' 	=> str_replace(",", ".", $_POST['amount']),
					'alias' 	=> $_POST['alias'],
					'state' 	=> $_POST['state'],
					'notes'		=> $_POST['notes']
				);

				$data['id'] = $this->payment_model->add($data);


			} else {

				$this->load->model("payment_model");

				$data = array(
					'date' 		=> $this->getMySQLDate($_POST['date']),
					'alias' 	=> $_POST['alias'],
					'amount' 	=> str_replace(",", ".", $_POST['amount']),
					'state' 	=> $_POST['state'],
					'notes'		=> $_POST['notes']
				);

				$this->payment_model->update($id, $this->db_session->userdata(AUTH_SECURITY_USER_ID), $data);

			}

			$stateName = array(
				0 => 'Programado',
				1 => 'Vencido',
				2 => 'Pagado',
				3 => 'Descartado'
			);
			$data['stateName']	= $stateName[$_POST['state']];
			$data['color']		= "#FFFFFF";
			
			$data['date'] = $_POST['date'];

			if($id == 0) {
				$this->load->view("payment/p_line", array('payment' => $data), false);
			}
		}

		
	}
	
	public function index($bill_id) {

		if(isset($bill_id)) {
			$this->load->model('bills_model');
			if($this->bills_model->exists($bill_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
				
				$data['bill'] = $this->bills_model->details($bill_id, $this->db_session->userdata(AUTH_SECURITY_USER_ID));
				
				$this->load->model('payment_model');
				$data['payments'] = $this->payment_model->getList($bill_id);
				$data['bill']['id'] = $bill_id;
				
				$this->layouts($this->load->view("bills/add_payment", $data, true));
			}
			
		}
		
	}
	
	public function resume() {

		$this->load->model('payment_model');

		$data['payments'] = $this->payment_model->getDueByUser($this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$data['bill']['id'] = '';

 		$data['totals'] = $this->getTotals($data['payments']);
		$data['percent'] = $this->getPercents($data['totals']['global']);
		//$data['grafica'] = $this->getGraph($data['payments']);
		
		$this->layouts($this->load->view("payment/resume", $data, true));
		
	}
	
}

?>