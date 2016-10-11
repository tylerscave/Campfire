<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * CreateGroup.php is the controller for createGroup_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class CreateGroup extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('user_model');
		if (!$this->session->userdata('login')) {
			redirect('home/index');
		}
	}

	function index() {
		// set form validation rules
		$this->form_validation->set_rules('groupName', 'Group Name', 'trim|required|alpha|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('zip', 'Group Zip Code', 'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('description', 'Group Description', 'trim|required|alpha|min_length[1]|max_length[200]|xss_clean');
		
		// get user information from session data to create basic profile
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->user_fname . " " . $details[0]->user_lname;
		$data['uemail'] = $details[0]->user_email;

		// load and populate the profile_view
		$this->load->view('createGroup_view', $data);
	}
}
