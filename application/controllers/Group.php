<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * Group.php is the controller for group_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class Group extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'html'));
		$this->load->library('session');
	}

	function index() {
		$this->load->view('group_view');
	}
}
