<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *COPYRIGHT (C) 2016 Tyler Jones. All Rights Reserved.
 * User_model.php is the model for the user
 * Solves SE148 Homework1
 * @author Tyler Jones
*/
class User_model extends CI_Model {

	// constructor for the user_model
	function __construct() {
		parent::__construct();
	}
	
	// get user for for login validation
	function get_user($email, $pwd) {
		$this->db->where('email', $email);
		$this->db->where('password', md5($pwd));
		$query = $this->db->get('user');
		return $query->result();
	}
	
	// get user by ID
	function get_user_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		return $query->result();
	}
	
	// insert new user into DB
	function insert_user($data) {
		return $this->db->insert('user', $data);
	}
}?>
