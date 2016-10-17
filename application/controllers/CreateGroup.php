<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * CreateGroup.php is the controller for createGroup_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, 
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class CreateGroup extends CI_Controller {
	private $upload_success;

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->upload_success = FALSE;
		$this->load->helper(array('url','html'));
		$this->load->helper('security');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('group_model');
		if (!$this->session->userdata('login')) {
			redirect('home/index');
		}
	}

	function index() {
		//dynamically populate the tag_list for the dropdown
		$data['tag_list'] = $this->group_model->get_dropdown_list();

		// set form validation rules
		$this->form_validation->set_rules('groupName', 'Group Name', 'trim|required|regex_match[#^[a-zA-Z0-9\'-]+$#]|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('zip', 'Group Zip Code', 'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('description', 'Group Description', 'required|max_length[200]|xss_clean');
		
		// submit the form and validate
		if ($this->form_validation->run() == FALSE) {
			// if it fails just load the view again
			$this->load->view('createGroup_view', $data);
		} else {
			//prepare to insert group details into organization table
			$group_data = array(
				'org_title' => $this->input->post('groupName'),
				'org_description' => $this->input->post('description'),
			);
			//prepare to insert user location details into location table
			$location_data = array(
				'city' => '',
				'zipcode' => $this->input->post('zip')
			);
			//prepare to insert group tag details into tag table
			$tag_data = array(
				'tag_title' => $this->input->post('tag')
			);
			//prepare to insert owner id into owner table
			$owner_data = array(
				'user_id' => $this->session->userdata('uid')
			);
			
			if ($this->group_model->insert_group($group_data, $location_data, $tag_data, $owner_data)) {
				// success!!!
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Group has been successfully created!</div>');
				redirect('createGroup/index');
			} else {
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('createGroup/index');
			}
		}
	}
	
	 public function do_upload() {
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
		$config['file_name'] = $this->session->userdata('fname') . time();
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('imageUpload')) {
			$this->upload_success = FALSE;
			redirect('createGroup/index');
		} else {
			$this->upload_success = TRUE;
		}
	}
}
