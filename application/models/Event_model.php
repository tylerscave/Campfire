<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * Group_model.php is the model for a group
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle,
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class Event_model extends CI_Model {
	// constructor for the user_model
	function __construct() {
		parent::__construct();
	}

	// Get all tags for the dropdown list
	function get_dropdown_list() {
		$this->db->from('tag');
		$this->db->order_by('tag_id');
		$result = $this->db->get();
		$return = array();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['tag_id']] = $row['tag_title'];
			}
		}
		return $return;
	}

	// get events created by or RSVP'd for
	function get_events_by_user_id($id, $user_type) {

		if ($user_type == 'member') {
			$data = $this->db->query('SELECT e.event_id, e.event_description 
									  FROM event e JOIN 
											(SELECT * FROM user u JOIN member m USING(user_id) JOIN organization_event ev USING(org_id) 
											 WHERE u.user_id = '.$id.') AS f USING(event_id)');
		}
		else if ($user_type == 'owner') {
			$data = $this->db->query('SELECT e.event_id, e.event_description 
									  FROM event e JOIN 
											(SELECT * FROM user u JOIN owner m USING(user_id) JOIN organization_event ev USING(org_id) 
											 WHERE u.user_id = '.$id.') AS f USING(event_id)');
		}
		else {
			return null;
		}

		return $data->result();
	}
}
