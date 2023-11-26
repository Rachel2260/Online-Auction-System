<?php
  // Database Connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "online_auction_system_1";

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