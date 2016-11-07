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
			$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($zip));
			$match = json_decode($json);
			$group_search_info = $this->group_model->search_groups_zip($match->results[0]->geometry->location->lat, $match->results[0]->geometry->location->lng);
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
			$uid = $this->session->userdata('uid');
			$arr['gID'] = $gID;
			$data['info'] = $this->group_model->get_group_by_id($gID);
			$data['members'] = $this->group_model->get_group_members($gID);
			$data['bulletins'] = $this->group_model->get_bulletins($gID);

			$member_status = 'nonmember';
			if ($this->session->userdata('login') == FALSE) {
				$member_status = 'notlogged';
			}
			else if ( $uid == $data['info']['user_id']) {
				$member_status = 'owner';
			}
			else {
				foreach($data['members'] as $row) {
					if ($row['user_id'] == $uid) {
						$member_status="member";
					}
				}
			}

			$data['status'] = $member_status;
			if ($data != NULL) {
				$this->load->view('group_view', $data);
			} else {
				redirect('group/search');
			}
		} else {
			redirect('group/search');
		}


	}

	function join_group($gID = NULL) {
		if ($gID != NULL) {
			$arr['gID'] = $gID;
			$uid = $this->session->userdata('uid');
			$this->group_model->join_group($uid, $gID);
		}
		redirect('group/display/'.$gID);
	}

	function leave_group($gID = NULL) {
		if ($gID != NULL) {
			$arr['gID'] = $gID;
			$uid = $this->session->userdata('uid');
			$this->group_model->leave_group($uid, $gID);
		}
		redirect('group/display/'.$gID);
	}
}
