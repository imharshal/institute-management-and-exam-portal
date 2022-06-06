<?php
 $servername = "sql347.main-hosting.eu";
 $username = "u634078165_avinash";
 $password = "Avinash@123";
 $dbname = "u634078165_website";

//  $servername = "localhost";
//  $username = "root";
//  $password = "";
//  $dbname = "ssd-website";
      
 // creating the connection
 $connect = new mysqli($servername, $username, $password, $dbname);
  
 // checking the connection
 if(!$connect->connect_error) {
     // echo "Successfully connected";
 }
 else {
     die("Connection Failed : " . $connect->connect_error);
 }
?>