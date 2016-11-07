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
	function get_events_by_user_id($id, $retrieval_type) {

		
		if ($retrieval_type == 'owned') 
		{
			$data = $this->db->query('SELECT * FROM event ev JOIN 
										(SELECT event_id FROM event_owner ow 
											WHERE ow.owner_id = (SELECT owner_id FROM user u JOIN owner o WHERE u.user_id = '.$id.' AND o.user_id = u.user_id)) AS f 
										USING(event_id)');
			
		}
		else if ($retrieval_type == 'rsvp') 
		{
			$data = $this->db->query('SELECT * FROM event ev JOIN 
										(SELECT event_id FROM attendee a 
											WHERE a.user_id = (SELECT user_id FROM user u WHERE u.user_id = '.$id.')) AS f 
										USING(event_id)');
		}
		else {
			return null;
		}

		return $data->result();
	}

	// delete event by event id
	function delete_event($event_id) {
		$this->db->delete('event', array('event_id' => $event_id));
		$this->db->delete('event_bulletin', array('event_id' => $event_id));
		$this->db->delete('event_owner', array('event_id' => $event_id));
		$this->db->delete('event_location', array('event_id' => $event_id));
		$this->db->delete('event_tag', array('event_id' => $event_id));
	}
}
