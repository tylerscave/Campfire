<?php
/**
 *COPYRIGHT (C) 2016 Campfire. All Rights Reserved.
 * EditEvent.php is the controller for editEvent_view.php
 * Solves SE165 Semester Project Fall 2016
 * @author Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle,
 *     Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma
*/
class EditEvent extends CI_Controller {
	// constructor used for needed initialization
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'security'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('group_model');
		$this->load->model('event_model');
		if (!$this->session->userdata('login')) {
			redirect('home/index');
		}
	}

	function index($event_id = NULL) {
		//new directory for images
		$targetDir = './uploads/';
		// if there was an error on last edit, recapture event id
		if ($event_id == NULL) {
			$event_id = $this->session->userdata('event_id');
		}
		// if the event was successfully edited redirect after delay to show success
		if ($this->session->flashdata('editSuccess')) {
			header("refresh:5; url=".base_url()."/index.php/event/display/".$event_id);
		}
		if ($event_id != NULL) {
			// find all events owned by this member 
			$eventsOwned = $this->event_model->get_owned_by_uid($this->session->userdata('uid'));
			$owned = FALSE;
			// Check if user is owner of this event
			foreach ($eventsOwned as &$value) {
				if ($event_id == $value->event_id) {
					$owned = TRUE;
					break;
				}
			}
			// If not the owner of this group, then redirect
			if (!$owned) {
				redirect('home/index');
			}
			// Get the old group data before update and add to $data
			$data['oldEventData'] = $this->event_model->get_event_by_id($event_id);
			//dynamically populate the tag_list for the dropdown
			$data['tag_list'] = $this->group_model->get_dropdown_list();
			// update the session variables
			$sess_data = array('event_id' => $event_id, 'oldPhoto' => $data['oldEventData']['event_picture']);
			$this->session->set_userdata($sess_data);
		} else { 
			// something went wrong and cannot get gID -> so get out of here
			redirect('home/index');
		}

		//dynamically populate the tag_list for the dropdown
		$data['tag_list'] = $this->event_model->get_dropdown_list();
		//new directory for images
		$targetDir = './uploads/';
		// set form validation rules
		$this->form_validation->set_rules('eventName', 'Event Name', 'trim|required|regex_match[#^[a-zA-Z0-9 \'-]+$#]|min_length[1]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('eventName', 'Event Name', 'callback_badWord_check');
		$this->form_validation->set_rules('zip', 'Event Zip Code', 'trim|required|numeric|min_length[5]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('description', 'Event Description', 'required|max_length[200]|xss_clean');
		$this->form_validation->set_rules('description', 'Event Description', 'callback_badWord_check');
		if (!empty($_FILES['imageUpload']['tmp_name'])) {
			$this->form_validation->set_rules('imageUpload', 'Upload and Image', 'callback_ext_check');
		}
		
		// submit the form and validate
		if ($this->form_validation->run() == FALSE) {
			// if it fails just load the view again
			$this->load->view('editEvent_view', $data);
		} else {
			//Upload a new image if it exists
			if (!empty($_FILES['imageUpload']['tmp_name'])) {
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
				$upload_success = imagejpeg($tmp, $newFileName, 100);
				// Remove the old image if a new image has been uploaded
				$remove_success = $this->removeImage($this->session->userdata('oldPhoto'));
				//cleanup
				imagedestroy($image);
				imagedestroy($tmp);
			} else {
				//If no new image is selected, keep the old one
				$simpleNewFileName = $this->session->userdata('oldPhoto');
			}
			//prepare to insert group details into organization table
			$event_data = array(
				'event_id' => $this->session->userdata('event_id'),
				'event_title' => $this->input->post('eventName'),
				'event_description' => $this->input->post('description'),
				'event_picture' => $simpleNewFileName,
				'event_tag' => $this->input->post('tag')
			);
			//prepare to insert user location details into location table
			$location_data = array(
				'address_one' => '',
				'address_two' => '',
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
			
			// Set error/success messages
			if ($this->event_model->update_event($event_data, $location_data, $tag_data)) { // success!!!
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Event has been successfully updated with the new information! You will be redirected shortly.</div>');
				$this->session->set_flashdata('editSuccess', true);
				redirect('editEvent/index');
			} else { // error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error. Please try again later!!!</div>');
				redirect('editEvent/index');
			}
		}
	}
	
    //DONE
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
	
    //DONE
	function badWord_check($input) {
		$fh = fopen(base_url().'assets/text_input/badWords.txt', 'r') or die($php_errormsg);
		$line = fgets($fh);
		fclose($fh);
		if (preg_match($line, strtolower($input))) {
			$this->form_validation->set_message('badWord_check', 'You have entered an inappropriate word! Lets keep it clean!!!.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
    //DONE
	function removeImage($fileName) {
		$path = './uploads/'.$fileName;
		if(unlink($path)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
    //DONE
	function deleteEvent($event_id) {
		//Delete the image from the uploads folder
		$data['oldEventData'] = $this->event_model->get_event_by_id($event_id);
		$this->removeImage($data['oldEventData']['event_picture']);
		//Delete from the database using the org_ID
		$this->event_model->delete_event($event_id);
		redirect('myEvents/index');
	}
}
