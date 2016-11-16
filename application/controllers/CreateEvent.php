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
		$this->form_validation->set_rules('eventTitle', 'Event Title', 'trim|required|callback_check_text|min_length[1]|max_length[30]|xss_clean');
			// array('check_text' => 'This text is not allowed.')

		$this->form_validation->set_rules('address1','Street address', 'trim|required|xss_clean'); 
		$this->form_validation->set_rules('address2','Street address', 'trim|xss_clean'); 
		$this->form_validation->set_rules('eventCity','City', 'trim|required|xss_clean'); 
		$this->form_validation->set_rules('eventState','State', 'trim|required|min_length[2]|max_length[2]|xss_clean');
		$this->form_validation->set_rules('eventZip','Event Zip Code', 
			'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');

		$this->form_validation->set_rules('eventDTStart', 'Event Start', 'trim|required|xss_clean');
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
		//works
		//put back in post

		//prepare to insert group details into event table
		$event_data = array(
			'event_title' => $this->input->post('eventTitle'),
			'event_description' => $this->input->post('eventDescription'),
			'event_begin_datetime' => $eventData["startTime"],
			'event_end_datetime' => $eventData["endTime"],
			'event_picture' => "test picture"
		);
		// print_r($event_data);

		//prepare to insert user location details into location table
			$location_data = array(
				'address_one' => $this->input->post('address1'),
				'address_two' => $this->input->post('address2'),
				'city' => $this->input->post('eventCity'),
				'state' => $this->input->post('eventState'),
				'zipcode' => $this->input->post('eventZip'),
			  	'geolat' =>'',
				'geolng' =>''
			);

		// //prepare to insert group tag details into tag table
		// $eventtag_data = array(
		// 	'tag_title' => $this->input->post('tag')
		// );

		// //prepare to insert owner id into owner table
		// $eventowner_data = array(
		// 	'user_id' => $this->session->userdata('uid')
		// );	

		if ($this->event_model->insert_event($event_data, $location_data/*, $eventtag_data, $eventowner_data*/)){
			// success!!!
			// echo "event success";

			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Event has been successfully created!</div>');
			redirect('createEvent/index');

			} else {
				// error!!!
				// $this->removeImage($simpleNewFileName); // Remove image upload if group was not created
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				echo "event error";
				// redirect('createEvent/index');

			}
		} //else	
	}//createEvent

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
/**
 * States Dropdown 
 *
 * @uses check_select
 * @param string $post, the one to make "selected"
 * @param string $type, by default it shows abbreviations. 'abbrev', 'name' or 'mixed'
 * @return string
 */
function StateDropdown($post=null, $type='abbrev') {
	$states = array(
		array('AK', 'Alaska'),
		array('AL', 'Alabama'),
		array('AR', 'Arkansas'),
		array('AZ', 'Arizona'),
		array('CA', 'California'),
		array('CO', 'Colorado'),
		array('CT', 'Connecticut'),
		array('DC', 'District of Columbia'),
		array('DE', 'Delaware'),
		array('FL', 'Florida'),
		array('GA', 'Georgia'),
		array('HI', 'Hawaii'),
		array('IA', 'Iowa'),
		array('ID', 'Idaho'),
		array('IL', 'Illinois'),
		array('IN', 'Indiana'),
		array('KS', 'Kansas'),
		array('KY', 'Kentucky'),
		array('LA', 'Louisiana'),
		array('MA', 'Massachusetts'),
		array('MD', 'Maryland'),
		array('ME', 'Maine'),
		array('MI', 'Michigan'),
		array('MN', 'Minnesota'),
		array('MO', 'Missouri'),
		array('MS', 'Mississippi'),
		array('MT', 'Montana'),
		array('NC', 'North Carolina'),
		array('ND', 'North Dakota'),
		array('NE', 'Nebraska'),
		array('NH', 'New Hampshire'),
		array('NJ', 'New Jersey'),
		array('NM', 'New Mexico'),
		array('NV', 'Nevada'),
		array('NY', 'New York'),
		array('OH', 'Ohio'),
		array('OK', 'Oklahoma'),
		array('OR', 'Oregon'),
		array('PA', 'Pennsylvania'),
		array('PR', 'Puerto Rico'),
		array('RI', 'Rhode Island'),
		array('SC', 'South Carolina'),
		array('SD', 'South Dakota'),
		array('TN', 'Tennessee'),
		array('TX', 'Texas'),
		array('UT', 'Utah'),
		array('VA', 'Virginia'),
		array('VT', 'Vermont'),
		array('WA', 'Washington'),
		array('WI', 'Wisconsin'),
		array('WV', 'West Virginia'),
		array('WY', 'Wyoming')
	);
	
	$options = '<option value=""></option>';
	
	foreach ($states as $state) {
		if ($type == 'abbrev') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[0].'</option>'."\n";
    } elseif($type == 'name') {
    	$options .= '<option value="'.$state[1].'" '. check_select($post, $state[1], false) .' >'.$state[1].'</option>'."\n";
    } elseif($type == 'mixed') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[1].'</option>'."\n";
    }
	}
		
	echo $options;
}

/**
 * Check Select Element 
 *
 * @param string $i, POST value
 * @param string $m, input element's value
 * @param string $e, return=false, echo=true 
 * @return string 
 */
function check_select($i,$m,$e=true) {
	if ($i != null) { 
		if ( $i == $m ) { 
			$var = ' selected="selected" '; 
		} else {
			$var = '';
		}
	} else {
		$var = '';	
	}
	if(!$e) {
		return $var;
	} else {
		echo $var;
	}
}

}//controller































