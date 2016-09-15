
<?php require_once 'config/config.php'?> 
<?php
try{
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //  $stmt = $conn->prepare("");

  //  $status = $stmt->execute();
    print_r($_GET);

}
catch(PDOException $ex) {
    echo 'ERROR: ' . $ex->getMessage();
}
?>
