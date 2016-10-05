<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * EditProfile.php is the controller for editProfile_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class EditProfile extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->helper('security');
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('user_model');

	}

	function index() {
		$user_id = $this->session->userdata('uid');
		$userData = $this->user_model->get_user_by_id($user_id);
		
		// set form validation rules
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha|min_length[3]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha|min_length[3]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');
		
		
		
		if ($this->input->post('cancel')) {
			redirect('home/index');
		} else if ($this->form_validation->run() == FALSE) {
	
			// if it fails just load the view again
			$this->load->view('editProfile_View');
 			
 		} else {
			//prepare to update user details into user table
			$user_data = array(
				'user_fname' => $this->input->post('fname'),
				'user_lname' => $this->input->post('lname'),
				'user_email' => $this->input->post('email'),
				'User_password' => md5($this->input->post('password', TRUE))
			);
			//prepare to update user location details into location table
			$location_data = array(
				'zipcode' => $this->input->post('zip')
			);
			
			if ($this->user_model->update_user($user_id, $user_data, $location_data)) {
				// success!!!
				$sess_data = array('login' => TRUE, 'uname' => $user_data['user_fname'], 'uid' => $user_id);
				$this->session->set_userdata($sess_data);
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">You have Successfully Updated your account! </div>');
				redirect('editProfile/index');
			} else {
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('editProfile/index');
			}
		}
	}
	
	function deleteUser() {
		$user_id = $this->session->userdata('uid');
		$userData = $this->user_model->get_user_by_id($user_id);
		//Delete from the database using the User ID
		$this->user_model->delete_user($user_id);
		//Delete the Session information
		$data = array('login' => '', 'uname' => '', 'uid' => '');
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
	}
}
