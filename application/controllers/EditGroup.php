<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * EditGroup.php is the controller for editGroup_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle,
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class EditGroup extends CI_Controller {
	protected $gID = NULL;

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

	function index($gID = NULL) {
		// Get the old group data before update
		if ($gID != NULL) {
			$this->gID = $gID;
			$data['oldGroupData'] = $this->group_model->get_group_by_id($gID);
		} else {
			$data['oldGroupData']['org_title'] = "";
			$data['oldGroupData']['zipcode'] = "";
		}

		//dynamically populate the tag_list for the dropdown
		$data['tag_list'] = $this->group_model->get_dropdown_list();

		//new directory for images
		$targetDir = './uploads/';

		// set form validation rules
		$this->form_validation->set_rules('groupName', 'Group Name', 'trim|required|regex_match[#^[a-zA-Z0-9 \'-]+$#]|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('zip', 'Group Zip Code', 'trim|required|numeric|min_length[5]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('description', 'Group Description', 'required|max_length[200]|xss_clean');
		if (!empty($_FILES['imageUpload']['tmp_name'])) {
			$this->form_validation->set_rules('imageUpload', 'Upload and Image', 'callback_ext_check');
		}

		// submit the form and validate
		if ($this->form_validation->run() == FALSE) {
			// if it fails just load the view again
			$this->load->view('editGroup_view', $data);
		} else {
			if (false) {
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
			} else {
				$simpleNewFileName = $data['oldGroupData']['org_picture'];
			}

			//prepare to insert group details into organization table
			$group_data = array(
				'org_id' => $gID,
				'org_title' => $this->input->post('groupName'),
				'org_description' => $this->input->post('description'),
				'org_picture' => $simpleNewFileName
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
			
			if (isset($simpleNewFileName)) {
				$deleteSuccess = $this->removeImage($data['oldGroupData']['org_picture']);
			}
			
			if ($this->group_model->edit_group($group_data, $location_data, $tag_data, $owner_data) && $image_success && $deleteSuccess) {
				// success!!!
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Group has been successfully updated with the new information!</div>');
				redirect('editGroup/index');
			} else {
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('editGroup/index');
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
	
	function removeImage($fileName) {
		$path = './uploads/'.$fileName;
		if(unlink($path)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function deleteGroup() {
		$gID = $this->gID;
		$groupData = $this->group_model->get_group_by_id($gID);
		//Delete from the database using the User ID
		$this->group_model->delete_group($groupData);
	}
}