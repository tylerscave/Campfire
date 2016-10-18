<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * Group_model.php is the model for a group
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class Group_model extends CI_Model {

	// constructor for the user_model
	function __construct() {
		parent::__construct();
	}
	
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
	
	// insert new user into DB
	function insert_group($group_data, $location_data, $tag_data, $owner_data) {
		// insert values into organization
		$group_success = $this->db->insert('organization', $group_data);
		// Get the group ID and add it to the owner_data array
		$group_id = $this->db->insert_id();
		$owner_data['org_id'] = $group_id; 
		// insert values into location
		$location_success = $this->db->insert('location', $location_data);
		// Get the location ID
		$location_id = $this->db->insert_id();
		// Get the tag ID
		$this->db->where('tag_title', $tag_data['tag_title']);
		$query = $this->db->get('tag');
		$tag_id_array = $query->result();
		$tag_id = $tag_id_array[0]->tag_id;
		// insert values into owner, admin, and member
		$owner_success = $this->db->insert('owner', $owner_data);
		$admin_success = $this->db->insert('admin', $owner_data);
		$member_success = $this->db->insert('member', $owner_data);
		// Create arrays of id_data to insert in DB
		$location_id_data = array(
			'org_id' => $group_id,
			'location_id' => $location_id
		);
		$tag_id_data = array(
			'org_id' => $group_id,
			'tag_id' => $tag_id
		);
		// Call function to insert ids into organization_location and organization_tag
		$id_success = $this->insert_ids($location_id_data, $tag_id_data);
		// return true only if all inserts were successful
		return ($group_success && $location_success && $owner_success &&
				$admin_success && member_success && $id_success);
	}
	
	// insert ids into organization_location and organization_tag
	function insert_ids($location_id_data, $tag_id_data) {
		$location_success = $this->db->insert('organization_location', $location_id_data);
		$tag_success = $this->db->insert('organization_tag', $tag_id_data);
		return ($location_success && $tag_success);
	}
	
	// get groups joined, owned, or admined
	function get_groups($id, $user_type) {
		
		if ($user_type == 'member') {
			$data = $this->db->query('SELECT * FROM organization c JOIN
									(SELECT m.org_id FROM user u JOIN member m WHERE u.user_id = m.user_id and u.user_id = '.$id.') 
										AS f WHERE f.org_id = c.org_id');
		}
		else if ($user_type == 'owner') {
			$data = $this->db->query('SELECT * FROM organization c JOIN
									(SELECT o.org_id FROM user u JOIN owner o WHERE u.user_id = o.user_id and u.user_id = '.$id.') 
										AS f WHERE f.org_id = c.org_id');
		}
		else if ($user_type == 'admin') {
			$data = $this->db->query('SELECT * FROM organization c JOIN
									(SELECT a.org_id FROM user u JOIN admin a WHERE u.user_id = a.user_id and u.user_id = '.$id.') 
										AS f WHERE f.org_id = c.org_id');
		}
		else {
			return null;
		}
								
		return $data->result();
	}
}
