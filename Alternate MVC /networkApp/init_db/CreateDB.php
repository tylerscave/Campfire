<?php
/**
 *COPYRIGHT (C) 2016 Tyler Jones. All Rights Reserved.
 * CreateDB.php can be run from the command-line to make a good initial database.
 * Solves SE148 Homework1
 * @author Tyler Jones
*/

//required for the constants
require_once "Config.php";

//Establish connection to database
$conn = new mysqli(HOST, USER, PWD, "");
//Check connection was successful
if($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error . "\n";
}
//Create the database
$sql = "CREATE DATABASE " . DB;
if($conn->query($sql) === TRUE) {
    echo "Database " . DB . " created successfully \n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}
//select the correct DB
$conn->select_db(DB);
//Create the USER table
$tbl = "CREATE TABLE user(
    id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fName VARCHAR(30),
    lName VARCHAR(30),
    email VARCHAR(60) UNIQUE NOT NULL,
    password VARCHAR(40) NOT NULL)
    ENGINE=MyISAM  DEFAULT CHARSET=latin1";
if ($conn->query($tbl) === TRUE) {
    echo "Table 'user' created successfully \n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}
$conn->query("ALTER TABLE USER AUTO_INCREMENT = 100000");

//Close the mysqli connection
$conn->close();

