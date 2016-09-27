
<?php require_once 'config/config.php'?> 
<?php
try{
  //  $stmt = $conn->prepare("");

  //  $status = $stmt->execute();
  
  //if($status){}

}
catch(PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}
?>
