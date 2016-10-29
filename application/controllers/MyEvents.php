<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * MyEvents.php is the controller for myEvents_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class MyEvents extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('event_model');
	}

	function index() {
		// get user information from session data to create basic profile
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->user_fname . " " . $details[0]->user_lname;
		$data['uemail'] = $details[0]->user_email;
		
		// get all events for user
		$group_member = $this->event_model->get_events_by_user_id($this->session->userdata('uid'), 'member');
		$group_owner = $this->event_model->get_events_by_user_id($this->session->userdata('uid'), 'owner');
		$data['memberedevents'] = $group_member;
		$data['ownedevents'] = $group_owner;

		// load and populate the profile_view
		$this->load->view('myEvents_view', $data);
	}
}
