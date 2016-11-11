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
	
	// get event by event id and return information
	function get_event_by_id($event_id) {
		$event_result = $this->db->query('SELECT a.event_id, a.event_title, a.event_description, a.event_begin_datetime, 
											a.event_end_datetime, a.event_picture, d.user_fname, d.user_id, d.user_lname, d.user_email, 
											e.address_one, e.address_two, e.zipcode, e.city, e.state, e.geolat, e.geolng 
											FROM event a, event_owner b, event_location c, user d, location e 
											WHERE a.event_id = '.$event_id.' 
											AND a.event_id = b.event_id 
											AND a.event_id = c.event_id 
											AND b.owner_id = d.user_id 
											AND c.location_id = e.location_id');
		$query = $event_result->result_array();
		if ($query != null) {
			$event_data = $query[0];
		}
		if (isset($event_data)) {
			return $event_data;
		}
		return NULL;
	}
	
	// get first and last name of members in a group
	function get_event_members($event_id) {
		$query = $this->db->query('SELECT user.user_id, user.user_fname, user.user_lname
											FROM user, attendee
											WHERE user.user_id = attendee.user_id
											AND attendee.event_id = '.$event_id.';');
		$event_members = array();
		foreach ($query->result_array() as $row) {
			$event_members[] = array('user_fname' => $row['user_fname'], 'user_lname' => $row['user_lname'], 'user_id' =>$row['user_id']);
		}
		return $event_members;
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
	
	// gets bulletin message for group
	function get_bulletins($eventId) {
		$query = $this->db->query('SELECT bulletin_message, bulletin_datetime, user_fname, user_lname
									FROM bulletin
									LEFT JOIN user ON bulletin_user_id  = user_id
									WHERE bulletin_id IN (SELECT bulletin_id
									                        FROM event_bulletin
									                        WHERE event_id = '.$eventId.')
									AND bulletin_datetime >= DATE_ADD(NOW(), INTERVAL -30 DAY)');
		$event_bulletins = array();
		foreach ($query->result_array() as $row) {
			$event_bulletins[] = array('user_fname' => $row['user_fname'], 'user_lname' => $row['user_lname'],
					'bulletin_message' =>$row['bulletin_message'], 'bulletin_datetime' => $row['bulletin_datetime']);
		}
		return $event_bulletins;
	}
	
	// join a group
	function join_event($uid, $eventId) {
		$data = array('user_id' => $uid, 'event_id' => $eventId);
		$this->db->insert('attendee', $data);
	}
	
	// leave a group
	function leave_event($uid, $eventId) {
		$this->db->delete('attendee', array('user_id' =>$uid, 'event_id' =>$eventId));
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
