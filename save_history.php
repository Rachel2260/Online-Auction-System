<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
<div class="container">

<?php
$user_ID = $_SESSION['user_ID'];
$auction_ID = $_GET['item_id'];
$sql = "INSERT INTO history (user_ID, auction_ID) VALUES($user_ID, $auction_ID)";

if ($conn->query($sql) != TRUE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>