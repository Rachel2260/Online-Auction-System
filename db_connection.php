<?php
  // Database Connection
  $servername = "localhost"; 

$username = "Group22user"; 

$password = "Group22"; 

$database = "Online_Auction_System"; 

  try {
    $conn = mysqli_connect($servername, $username, $password, $database);
      if (!$conn) {
          throw new Exception("Connection failed: " . mysqli_connect_error());
      }
  } catch (Exception $e) {
      echo "Connection failed. Message: " . $e->getMessage();
      exit;
  }
?>