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
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('group_model');
	}

	function index() {
		$this->load->view('group_view');
	}

	function search(){
		// get form input from the view
		$zip = $this->input->get('zip');

		if($zip){
			$group_search_info = $this->group_model->search_groups_zip($zip);
		}
		else{
			$group_search_info ='';
		}


		if($group_search_info){
			$groups = array();
			foreach($group_search_info as $key => $val){
				$groups[$key] = $val;
			}
			$arr['groups'] = $groups;
			$this->load->view('searchGroups_view', $arr);
		}
		else{
			$this->load->view('searchGroups_view');
		}
	}
	
	function display($gID){
		$arr['gID'] = $gID;
		$this->load->view('group_view', $arr);
	}
}
