<?php require("utilities.php")?>
<?php include_once("header.php");?>
<div class="container my-5">
<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.

    // include "listing.php";
    // Database Connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
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
    
    $bid_price = $_POST['bid_price'];
    $auction_id = $_GET['item_id'];
    $highest_price = current_price($auction_id);
    $sql = "SELECT starting_price FROM auction WHERE auction_ID = $auction_id";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_row($result);
    $starting_price = $row[0];
 
    if ($bid_price !=NULL and $bid_price > $highest_price and $bid_price >$starting_price){
        echo('<div class="text-center">You bid successfully! <a href="mybids.php">View your bids.</a ></div>');
    }else{
        echo('<div class="text-center">You bid unsuccessfully please set the price above highest price and start price! <a href="listing.php?item_id=' . $auction_id . '">Try again.</a ></div>');
    }
?>