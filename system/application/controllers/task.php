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

class task extends Controller {
	
    function __construct() {
	
    	parent::Controller();
		
		if($this->uri->segment(2, 0) == 'ical') {
			echo $this->str_rand(15, 'alphanum');
		} else {
			if(!$this->authlib->isValidUser()) {
				redirect('/auth/login', 'redirect');
			}
		}

	}

	private function str_rand($length = 8, $seeds = 'alphanum') {
	    // Possible seeds
	    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
	    $seedings['numeric'] = '0123456789';
	    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
	    $seedings['hexidec'] = '0123456789abcdef';

	    // Choose seed
	    if (isset($seedings[$seeds])) {
	        $seeds = $seedings[$seeds];
	    }

	    // Seed generator
	    list($usec, $sec) = explode(' ', microtime());
	    $seed = (float) $sec + ((float) $usec * 100000);
	    mt_srand($seed);

	    // Generate
	    $str = '';
	    $seeds_count = strlen($seeds);

	    for ($i = 0; $length > $i; $i++) {
	        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
	    }

	    return $str;
	}

	private function layouts($data) {
		
 		$this->load->view("layouts/admin", array(
			'content' => $data
		));

 	}

	public function index() {

		$this->load->model('task_model');
		$data['tasks'] = $this->task_model->getList($this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->load->model('company_model');
		$data['companies'] = $this->company_model->getCompanies($this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->layouts($this->load->view("task/index", $data, true));

	}

	public function update() {

		$this->load->model('company_model');

		if($this->company_model->exists($_POST['company_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID))) {
			
			$this->load->model('task_model');

			$d = explode(" / ", $_POST['date']);
			$date = $d[2]."-".$d[1]."-".$d[0]." ".$_POST['time'].":00";

			if($_POST['task_id'] == 0) { 	// ............ ADDING
				
				$data = array(
					'company_id' => $_POST['company_id'],
					'date' => $date,
					'title' => $_POST['title'],
					'color' => $_POST['color'],
					'text' => $_POST['text']
				);
				$data['id'] = $this->task_model->add($data);
				$this->load->model("company_model");
				$company = $this->company_model->details($_POST['company_id'], $this->db_session->userdata(AUTH_SECURITY_USER_ID));

				$data['company_color'] = $company['color'];
				$data['time'] = $_POST['time'];
				$data['date'] = $_POST['date'];
				$data['color'] = $_POST['color'];

				$this->load->view("task/p_line", array('task' => $data), false);
				
			} else { // .................................... EDITING

				$this->task_model->update(array(
					'company_id' => $_POST['company_id'],
					'date' => $date,
					'title' => $_POST['title'],
					'color' => $_POST['color'],
					'text' => $_POST['text']
				), $_POST['task_id']);
				
			}
			
		}
		

	}
	
	public function delete() {
		
		if($this->uri->segment(3, 0)) {
			$this->load->model('task_model');
			$this->task_model->delete($this->uri->segment(3, 0), $this->db_session->userdata(AUTH_SECURITY_USER_ID));
		}
		
	}

	public function ical() {

		$this->load->model('task_model');
		$tasks = $this->task_model->getList($this->db_session->userdata(AUTH_SECURITY_USER_ID));

		$this->load->plugin('to_calendar');
		
		$v = new vcalendar(); // create a new calendar instance
		$v->setConfig( 'unique_id', 'icaldomain.com' ); // set Your unique id
		$v->setProperty( 'method', 'PUBLISH' ); // required of some calendar software


		foreach($tasks as $task) {
			
			$d = explode(" / ", $task['date']);
			$t = explode(":", $task['time']);
			
			$vevent = new vevent(); // create an event calendar component
			$vevent->setProperty( 'dtstart', array( 
				'year'=>$d[0], 
				'month'=>$d[1], 
				'day'=>$d[2], 
				'hour'=>$t[0], 
				'min'=>$t[1],  
				'sec'=>'00' 
			));
			$vevent->setProperty( 'dtend',  array( 'year'=>$d[0], 'month'=>$d[1], 'day'=>$d[2], 'hour'=>$t[0], 'min'=>($t[1]+15),  'sec'=>'00' ));
			$vevent->setProperty( 'LOCATION', 'GesClick' ); // property name - case independent
			$vevent->setProperty( 'summary', $task['title'] );
			$vevent->setProperty( 'description', $task['text'] );
			$vevent->setProperty( 'comment', '' );
			$vevent->setProperty( 'attendee', 'admin@webclau.com' );
			$v->setComponent ( $vevent ); // add event to calendar
			
		}

		$v->returnCalendar(); // redirect calendar file to browser

	}



}

?>