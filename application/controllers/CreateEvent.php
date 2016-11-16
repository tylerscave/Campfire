<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * CreateEvent.php is the controller for createEvent_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class CreateEvent extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url','html','security', 'date'));
		// $this->load->library(array('session','javascript','javascript/jquery','form_validation'));
		$this->load->library(array('session','form_validation'));
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('event_model');
		$this->load->model('group_model');
		// $this->jquery->event('#startDate', jsFunction());

		if (!$this->session->userdata('login')) {
			redirect('home/index');
		}
	}
	function index() {
		//dynamically populate the tag_list for the dropdown
		$data['tag_list'] = $this->event_model->get_dropdown_list();

		// get user information from session data to create basic profile
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->user_fname . " " . $details[0]->user_lname;
		$data['uemail'] = $details[0]->user_email;

		// $this->load->view('createEvent_view', $data);
	// }

	/*
	* Responsible for creating the event
	* Validate, prep data in validate order, pass to model, provide feedback.
	*/
	// function createEvent(){	
		//Event pictures
		//new directory for event images
		// $targetDir = './uploads/';

		//Event form
		//set form validations
		// $this->form_validation->set_rules('eventTitle', 'Event Title', 'trim|required|regex_match[	#]|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('eventTitle', 'Event Title', 'trim|required|callback_check_text|min_length[1]|max_length[30]|xss_clean');
			// array('check_text' => 'This text is not allowed.')
		
		$this->form_validation->set_rules('eventZip','Event Zip Code', 
			'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('eventDTStart', 'Event Start', 'trim|required|xss_clean');
			// array(	'trim' => 'trim.',
			// 		'required'=> 'required.'
			// 	);

		$this->form_validation->set_rules('eventDTEnd', 'Event End', 'trim|xss_clean');
		$this->form_validation->set_rules('eventDescription', 'Event Description', 'trim|required|max_length[200]|xss_clean');

		// submit the form and validate
		if ($this->form_validation->run() == FALSE) {
			// if it fails just load the view again
			$this->load->view('createEvent_view', $data);
		}else{ //form validations work correctly
            // redirect('home/index'); 

        //translate user dates to "yyyy-mm-dd hh:mm:ss format"
	    $startdate = $this->input->post('eventDTStart');
   		$eventData["startTime"] = date('Y-m-d H:i:s', strtotime($startdate));

	    $enddate = $this->input->post('eventDTEnd');
		$eventData["endTime"] = date('Y-m-d H:i:s', strtotime($enddate));
		// print_r($eventData["startTime"]);
		//works

		// $date = date("Y-m-d H:i:s", $myTime);
		// $format = "MM/DD/YY HH:II";
		// $dateobj = DateTime::createFromFormat($format, $eventData["startTime"]);
		// print_r($dateobj);	

		//put back in post

		// $date = 'date('Y-m-d', strtotime($when));
		// print_r($date);
		// $startDT = date_format($date,"Y-m-d H:i:s");
		// $startDT = human_to_unix('eventDTStart');
		// print_r($startDT);
		// $datestring = 'Year: %Y Month: %m Day: %d - %h:%i %a';
		// $time = human_to_unix('eventDTStart');
		// $startDT1 = mdate($datestring, $time);
		// print_r($startDT1);

		// $myTime = strtotime("eventDTStart"); 
		// $myTime = unix_to_human($time = 'eventDTStart', $fmt = 'us')
		// print_r(eventDTStart);
		// $myTime = now(); 
		// print_r($myTime);
		// $myTime = strtotime("08/19/2014 1:45 pm"); 
		// echo date("Y-m-d H:i:s", $myTime);

		// $startT= date("Y-m-d H:i:s", $myTime);
		// print_r($startDT);
		// $format = "MM/DD/YY HH:II";
		// $dateobj = DateTime::createFromFormat($format, now());
		// print_r($dateobj);		

		// $dateobj = DateTime::createFromFormat($format, $myTime);
		// print_r($dateobj);


		//prepare to insert group details into event table
		$event_data = array(
			'event_title' => $this->input->post('eventTitle'),
			'event_description' => $this->input->post('eventDescription'),
			'event_begin_datetime' => $eventData["startTime"],
			'event_end_datetime' => $eventData["endTime"],
			'event_picture' => "this is a test"
		);
		// print_r($event_data);

		// //prepare to insert user location details into location table
		// 	$location_data = array(
		// 		'address_one' => '',
		// 		'address_two' => '',
		// 		'zipcode' => $this->input->post('zip')
		// 	);

		// //prepare to insert group tag details into tag table
		// $eventtag_data = array(
		// 	'tag_title' => $this->input->post('tag')
		// );

		// //prepare to insert owner id into owner table
		// $eventowner_data = array(
		// 	'user_id' => $this->session->userdata('uid')
		// );	

		if ($this->event_model->insert_event($event_data) /*$eventlocation_data, $eventtag_data, $eventowner_data*/){
			// success!!!
			echo "event success";

			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Event has been successfully created!</div>');
			redirect('createEvent/index');

			} else {
				// error!!!
				// $this->removeImage($simpleNewFileName); // Remove image upload if group was not created
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				echo "event error";
				redirect('createEvent/index');

			}
		} //else	
	}//createEvent
	// function checkDateFormat($date) {
	// 	if (preg_match("/[0-31]{2}\/[0-12]{2}\/[0-9]{4}/", $date)) {
	// 		if(checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4)))
	// 			return true;
	// 		else
	// 			return false;
	// 	} else {
	// 		return false;
	// 	}
	// }//function

	/*
	* used to check description & title text
	*/
	function check_text($str){
		$pattern = '/^[a-z0-9]\-_/i';
			//cibtaubstgese characters
		if(preg_match($pattern, $str)){
			$this->form_validation->set_message('check_text','This is not valid for {field}. Please try again.');
			return FALSE;
		}else{
			return TRUE;
		}
		// $this->form_validation->set_rules('eventTitle', 'Event Title', 'trim|required|regex_match[#^[ \'a-zA-Z0-9]-]+$#]|min_length[1]|max_length[30]|xss_clean');
		// regex_match[#^[ \'a-zA-Z0-9]-]+$#]

	}
}//controller































