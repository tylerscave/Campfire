
<?php require_once 'config/config.php'?>
<?php
try{
	/*
	session_start(); //removed until we insert logout button

	//check if the users is already logged in
	if($_SESSION['UserID'] == true){
		echo 'User is already logged in';
		exit;
	}
	*/
	
	$email =  filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL);
	$password = filter_var($_POST['inputPassword'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("SELECT * FROM user WHERE user.user_password = '$password' AND user.user_email = '$email'");
    $stmt->execute();
    $row = $stmt->fetch();
    
    if(!$row)
    {
		//$_SESSION['Error'] = true;
        //header("Location: ../index.html");
		echo "Login Failed!";
    }
    else
    {
        //$_SESSION['UserID'] = $row['UserID'];
       // header("Location: ../profileindex.html");
	   echo "Login Success!";
    }
}
	
catch(PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}
?>