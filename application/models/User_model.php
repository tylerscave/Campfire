<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * User_model.php is the model for the user
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class User_model extends CI_Model {

	// constructor for the user_model
	function __construct() {
		parent::__construct();
	}
	
	// get user for for login validation
	function get_user($email, $pwd) {
		$this->db->where('user_email', $email);
		$this->db->where('user_password', md5($pwd));
		$query = $this->db->get('user');
		return $query->result();
	}
	
	// get user by ID
	function get_user_by_id($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('user');
		return $query->result();
	}
	
	// insert new user into DB
	function insert_user($user_data, $location_data) {
		// insert values into user
		$user_success = $this->db->insert('user', $user_data);
		// Get the user ID
		$user_id = $this->db->insert_id();
		// insert values into location
		$location_success = $this->db->insert('location', $location_data);
		// Get the location ID
		$location_id = $this->db->insert_id();
		// Create array of id_data to insert in DB
		$id_data = array(
			'user_id' => $user_id,
			'location_id' => $location_id
		);
		// Call function to insert user_id and location_id into DB
		$id_success = $this->insert_ids($id_data);
		// return true only if all inserts were successful
		return ($user_success && $location_success && $id_success);
	}
	
	// insert user_id and location_id into DB
	function insert_ids($id_data) {
		return $this->db->insert('user_location', $id_data);
	}
}?>
