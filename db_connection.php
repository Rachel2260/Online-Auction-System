<?php
  // Database Connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "Online_Auction_System";
 
  // connect to data base
  try{
    $conn = new mysqli($servername, 
                   $username, 
                   $password,
                   $dbname);
  }
  catch(mysqli_sql_exception){
    echo "could not connecte <br>";
  }
?>