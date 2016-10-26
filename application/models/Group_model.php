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

	// insert new group into DB
	function insert_group($group_data, $location_data, $tag_data, $owner_data) {
		// insert values into organization
		$group_success = $this->db->insert('organization', $group_data);
		// Get the group ID and add it to the owner_data array
		$group_id = $this->db->insert_id();
		$owner_data['org_id'] = $group_id;
		//Check if location is in database
		$this->db->start_cache();
		$this->db->where('zipcode', $location_data['zipcode']);
		$this->db->where('street', '');
		$query = $this->db->get('location');
		$this->db->stop_cache();
		$this->db->flush_cache();
		//If location isnt in database yet
		if ($query->num_rows() == 0){
			// insert values into location and get the location ID
			$location_success = $this->db->insert('location', $location_data);
			$location_id = $this->db->insert_id();
		} else {
			$locResult = $query->result();
			$location_id = $locResult[0]->location_id;
			$location_success = TRUE;
		}
		// Get and update geocode for this zipcode
		$geocode = $this->getGeo($location_data['zipcode']);
		$geo_success = $this->db->query('UPDATE location
							SET geolat = '.$geocode['lat'].', geolng = '.$geocode['lng'].'
							WHERE location_id = '.$location_id.'');
		// Get the tag ID
		$this->db->like('tag_title', $tag_data['tag_title']);
		$query = $this->db->get('tag');
		$tag_id_array = $query->result();
		$tag_id = $tag_id_array[0]->tag_id;
		// insert this user into owner, admin, and member
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
				$admin_success && $member_success && $id_success && $geo_success);
	}

	// insert ids into organization_location and organization_tag
	function insert_ids($location_id_data, $tag_id_data) {
		$location_success = $this->db->insert('organization_location', $location_id_data);
		$tag_success = $this->db->insert('organization_tag', $tag_id_data);
		return ($location_success && $tag_success);
	}
	
	// Get lattitude and longitude from zip
	function getGeo($zip) {
		if(!empty($zip)){
			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$zip.'&sensor=false'); 
			$output = json_decode($geocodeFromAddr);
			//Get latitude and longitute from json data
			$geocode['lat']  = $output->results[0]->geometry->location->lat; 
			$geocode['lng'] = $output->results[0]->geometry->location->lng;
			//Return latitude and longitude of the given address
			if(!empty($geocode)){
				return $geocode;
			}else{
				return false;
			}
		}else{
			return false;   
		}
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

	function get_group_by_id($group_id) {
		$group_result = $this->db->query('SELECT a.org_id, a.org_title, a.org_description, d.user_fname, d.user_lname, d.user_email, e.zipcode
										FROM organization a, owner b, organization_location c, user d, location e
										WHERE a.org_id = '.$group_id.'
										AND a.org_id = b.org_id
										AND a.org_id = c.org_id
										AND b.user_id = d.user_id
										AND c.location_id = e.location_id');
		$query = $group_result->result_array();
		if ($query != null) {
			$group_data = $query[0];
		}
		if (isset($group_data)) {
			return $group_data;
		}
		return NULL;
	}

	function get_group_members($group_id) {

	}

	//input: zip code
	//output: array of matching groups information
	function search_groups_zip($zip){
		$this->db->where('zipcode', $zip);
		$location_results = $this->db->get('location')->result();
		foreach ($location_results as &$location) {
					$this->db->where('location_id', $location->location_id);
					$org_result = $this->db->get('organization_location')->result();
					foreach($org_result as &$org_id){
							$this->db->where('org_id', $org_id->org_id);
							$org_list[] = $this->db->get('organization')->result();
					}
		}
		if(isset($org_list)){
			return $org_list;
		}
		return '';
	}

	//output: array of random groups information
	function get_random_groups(){
		$query	= $this->db->query("SELECT * FROM organization ORDER BY RAND() LIMIT 0,12;");
		return $query->result_array();
	}

	// updates group and location in DB
	function update_group($group_data, $location_data, $tag_data) {
		try {
			//update organization table with new values
			$this->db->start_cache();
			$this->db->where('org_id', $group_data['org_id']);
			$group_succes = $this->db->update('organization', $group_data);
			$this->db->stop_cache();
			$this->db->flush_cache();

			//Update group location with new value
			$this->db->start_cache();
			$this->db->where('zipcode', $location_data['zipcode']);
			$location_succes = $this->db->update('location', $location_data);
			$this->db->stop_cache();
			$this->db->flush_cache();

			// Get the tag ID
			$this->db->like('tag_title', $tag_data['tag_title']);
			$query = $this->db->get('tag');
			$tag_id_array = $query->result();
			$tag_id = $tag_id_array[0]->tag_id;
			$tag_id_data = array(
				'org_id' => $group_data['org_id'],
				'tag_id' => $tag_id
			);
			//Update group tag info with new values
			$this->db->start_cache();
			$this->db->where('org_id', $group_data['org_id']);
			$tag_success = $this->db->update('organization_tag', $tag_id_data);
			$this->db->stop_cache();
			$this->db->flush_cache();

			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	// delete group from database
	function delete_group($groupData) {
		$this->db->delete('organization', $groupData);
		$this->db->delete('organization_location', $groupData);
		$this->db->delete('organization_tag', $groupData);
		$this->db->delete('organization_event', $groupData);
	}
}
