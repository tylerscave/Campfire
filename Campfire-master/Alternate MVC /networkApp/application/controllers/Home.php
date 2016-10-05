<?php
/**
 *COPYRIGHT (C) 2016 Tyler Jones. All Rights Reserved.
 * Home.php is the controller for home_view.php
 * Solves SE148 Homework1
 * @author Tyler Jones
*/
class Home extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'html'));
		$this->load->library('session');
	}

	function index() {
		$this->load->view('home_view');
	}

	function logout() {
		// destroy session upon logout
		$data = array('login' => '', 'uname' => '', 'uid' => '');
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
		// return to home page, but logged out
		redirect('home/index');
	}
}


