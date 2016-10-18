<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * Event.php is the controller for event_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle,
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class Event extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'html'));
		$this->load->library('session');
	}

	function index() {
		$this->load->view('event_view');
	}
	function search(){
		$this->load->view('searchEvents_view');
	}
}
