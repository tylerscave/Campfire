<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * Profile.php is the controller for profile_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class Profile extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('user_model');
	}

	function index() {
		// get user information from session data to create basic profile
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->user_fname . " " . $details[0]->user_lname;
		$data['uemail'] = $details[0]->user_email;

		// load and populate the profile_view
		$this->load->view('profile_view', $data);
	}
}
