
<?php require_once 'config/config.php'?> 
<?php
try{
	//session_start(); //removed until we insert logout button
	$email =  filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL);  
	$password = filter_var($_POST['inputPassword'], FILTER_SANITIZE_STRING);
	$fname = filter_var($_POST['inputFname'], FILTER_SANITIZE_STRING);
	$lname = filter_var($_POST['inputLname'], FILTER_SANITIZE_STRING);
	$zip = filter_var($_POST['inputZip'], FILTER_SANITIZE_STRING);
		

	$stmt = $conn->prepare("INSERT INTO `user`(`user_email`, `user_password`, `user_fname`,`user_lname`) VALUES ('$email','$password', '$fname','$lname');");
	$status = $stmt->execute();
    
	if($status){
		$user_id = $conn->lastInsertId();
			
		$stmt = $conn->prepare("INSERT INTO `location` (`city`,`zipcode`) VALUES ('',$zip);");
		$stmt->execute();
		 
		$location_id = $conn->lastInsertId();
		 
		$stmt = $conn->prepare("SET FOREIGN_KEY_CHECKS=0;INSERT INTO `user_location`(`user_id`, `location_id`) VALUES ($user_id, $location_id);"); 
		$stmt->execute();
		 
	/*	 
		$_SESSION['LoggedIn'] = true;
		$_SESSION['UserID'] = $user_id;
	*/
		echo 'Registration Success!';
	}
}
catch(PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}
?>
