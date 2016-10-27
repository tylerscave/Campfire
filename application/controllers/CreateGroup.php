<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * CreateGroup.php is the controller for createGroup_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle,
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class CreateGroup extends CI_Controller {

	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper(array('url','html'));
		$this->load->helper('security');
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

		//new directory for images
		$targetDir = './uploads/';

		// set form validation rules
		$this->form_validation->set_rules('groupName', 'Group Name', 'trim|required|regex_match[#^[a-zA-Z0-9 \'-]+$#]|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('zip', 'Group Zip Code', 'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('description', 'Group Description', 'required|max_length[200]|xss_clean');
		if (empty($_FILES['imageUpload']['tmp_name'])) {
			$this->form_validation->set_rules('imageUpload', 'Upload and Image', 'required');
		} else {
			$this->form_validation->set_rules('imageUpload', 'Upload and Image', 'callback_ext_check');
		}

		// submit the form and validate
		if ($this->form_validation->run() == FALSE) {
			// if it fails just load the view again
			$this->load->view('createGroup_view', $data);
		} else {
			//calculate new image height to preserve ratio
			list($orig_w, $orig_h) = getimagesize($_FILES['imageUpload']['tmp_name']);
			$thumbSize = 500;
			$w_ratio = ($thumbSize / $orig_w);
			$h_ratio = ($thumbSize / $orig_h);
			if ($orig_w > $orig_h ) {//landscape
				$crop_w = round($orig_w * $h_ratio);
				$crop_h = $thumbSize;
			} elseif ($orig_w < $orig_h ) {//portrait
				$crop_h = round($orig_h * $w_ratio);
				$crop_w = $thumbSize;
			} else {//square
				$crop_w = $thumbSize;
				$crop_h = $thumbSize;
			}

			//new filename for uploaded file
			$filename = $_FILES['imageUpload']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$newFileName = $targetDir . '/' . $this->session->userdata('fname') . time() . "." . $ext;
			$simpleNewFileName = $this->session->userdata('fname') . time() . "." . $ext;
			//read binary data from image file
			$imgString = file_get_contents($_FILES['imageUpload']['tmp_name']);
			//create image from string
			$image = imagecreatefromstring($imgString);
			//correct orientation based on exif data using GD function
			$exif = exif_read_data($_FILES['imageUpload']['tmp_name']);
			if(!empty($exif['Orientation'])) {
				switch($exif['Orientation']) {
					case 8:
						$image = imagerotate($image,90,0);
						break;
					case 3:
						$image = imagerotate($image,180,0);
						break;
					case 6:
						$image = imagerotate($image,-90,0);
						break;
				}
			}
			$tmp = imagecreatetruecolor($thumbSize, $thumbSize);
			imagecopyresampled($tmp, $image, 0, 0, 0, 0, $crop_w, $crop_h, $orig_w, $orig_h);
			//Save image
			$image_success = imagejpeg($tmp, $newFileName, 100);
			//cleanup
			imagedestroy($image);
			imagedestroy($tmp);

			//prepare to insert group details into organization table
			$group_data = array(
				'org_title' => $this->input->post('groupName'),
				'org_description' => $this->input->post('description'),
				'org_picture' => $simpleNewFileName,
				'org_tag' => $this->input->post('tag')
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

			if ($this->group_model->insert_group($group_data, $location_data, $tag_data, $owner_data) && $image_success) {
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
	
	function ext_check() {
		$filename = $_FILES['imageUpload']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if (preg_match("/(jpg|jpeg|png)/",$ext)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('ext_check', 'Must be a jpg, jpeg, or png file.');
			return FALSE;
		}
	}
}
