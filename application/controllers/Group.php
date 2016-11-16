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
		$this->load->library(array('session', 'pagination'));
		$this->load->database();
		$this->load->model('group_model');
	}

	function index() {
		$this->load->view('group_view');
	}

	function search(){
		// get form input from the view
		$query = $this->input->get('groupQuery');

		if($query){

			$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($query)); //http request, output is a json object
			$match = json_decode($json);//decode json object into a php variable

			//if search is valid
			if(empty($match->results) == false){
				$group_search_info = $this->group_model->search_groups_query($match->results[0]->geometry->location->lat, $match->results[0]->geometry->location->lng); //input first geolocation
			}
		}
		else{
			$random_group_query = $this->group_model->get_random_groups();
		}


		if(isset($group_search_info)){//for displaying searched groups

			if(count($group_search_info) > 12){

				//Configuring for pagination to echo properly in searchGroups_view
				$config['total_rows'] = count($group_search_info)/12 ;
				$config['per_page'] = 1;
				$config['num_links'] = 3;
				$config['page_query_string'] = TRUE;
				$config['reuse_query_string'] = TRUE;
				$config['full_tag_open'] = '<nav><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="page-item" id="prev"> <a class="page-link"> <span aria-hidden="true">';
				$config['prev_tag_close'] = '</span></a></li>';
				$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] =  '<li class="page-item"><a class="page-link">';
				$config['num_tag_close'] =  '</a></li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="page-item" id="next"> <a class="page-link"> <span aria-hidden="true">';
				$config['next_tag_close'] = '</span></a></li>';
				$config['last_link'] = '&raquo;';
				$config['last_tag_open'] = '<li class="page-item"><a class="page-link" aria-label="Next"><span aria-hidden="true">';
				$config['last_tag_close'] = '</span></a></li>';
				$config['first_link'] = '&laquo;';
				$config['first_tag_open'] = '<li class="page-item"><a class="page-link" aria-label="Previous"><span aria-hidden="true">';
				$config['first_tag_close'] = '</span></a></li>';

				$this->pagination->initialize($config);


			}
			$arr['groups'] = $group_search_info;
			$this->load->view('searchGroups_view', $arr);
		}
		else if(isset($random_group_query)){ //for displaying random groups

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
