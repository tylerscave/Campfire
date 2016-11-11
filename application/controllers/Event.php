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
		$this->load->database();
		$this->load->model('event_model');
	}

	function index() {
		$this->load->view('event_view');
	}
	function search(){
		$this->load->view('searchEvents_view');
	}
	
	function display($eventID = NULL){
		if ($eventID != NULL) {
			$uid = $this->session->userdata('uid');
			$arr['eventID'] = $eventID;
			$data['info'] = $this->event_model->get_event_by_id($eventID);
			$data['members'] = $this->event_model->get_event_members($eventID);
			$data['bulletins'] = $this->event_model->get_bulletins($eventID);
	
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
				$this->load->view('event_view', $data);
			} else {
				redirect('event/search');
			}
		} else {
			redirect('event/search');
		}
	
	
	}
	
	function join_event($eventID = NULL) {
		if ($eventID != NULL) {
			$arr['eventID'] = $eventID;
			$uid = $this->session->userdata('uid');
			$this->event_model->join_event($uid, $eventID);
		}
		redirect('event/display/'.$eventID);
	}
	
	function leave_event($eventID = NULL) {
		if ($eventID != NULL) {
			$arr['eventID'] = $eventID;
			$uid = $this->session->userdata('uid');
			$this->event_model->leave_event($uid, $eventID);
		}
		redirect('event/display/'.$eventID);
	}
}
