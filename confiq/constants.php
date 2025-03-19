<?php
    //Session Start
    session_start();
    //Create Constants to store non repeating values
    define('SITEURL', 'http://localhost/exam_2/contact_us/index.php');
    define('LOCALHOST', 'localhost:3307');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'contact_us');
    //Execute query 
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME,DB_PASSWORD, DB_NAME) or die('Something Went Wrong');
   
?>