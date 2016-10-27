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
			$random_group_query = '';
		}
		else{
			$group_search_info = '';
			$random_group_query = $this->group_model->get_random_groups();
		}


		if($group_search_info){//for displaying searched groups

			$arr['groups'] = $group_search_info;
			$this->load->view('searchGroups_view', $arr);
		}
		else if($random_group_query){ //for displaying random groups

			$arr['random'] = $random_group_query;
			$this->load->view('searchGroups_view', $arr);
		}
		else{
			$this->load->view('searchGroups_view');
		}
	}

	function display($gID = NULL){
		if ($gID != NULL) {
			$arr['gID'] = $gID;
			$group_data = $this->group_model->get_group_by_id($gID);
			if ($group_data != NULL) {
				$this->load->view('group_view', $group_data);
			} else {
				redirect('group/search');
			}
		} else {
			redirect('group/search');
		}

	}
}
