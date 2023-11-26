<?php require("utilities.php")?>
<?php include_once("header.php");?>
<?php include "db_connection.php";?>
<div class="container my-5">
<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.

    // include "listing.php";
    
    $bid_price = $_POST['bid_price'];
    $auction_id = $_GET['item_id'];
    $highest_price = current_price($auction_id);
    $sql = "SELECT starting_price FROM auction WHERE auction_ID = $auction_id";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_row($result);
    $starting_price = $row[0];
    $user_id = $_SESSION["user_ID"];
    
    $time_of_bid = date('Y-m-d h:i:s', time());

    if ($bid_price !=NULL and $bid_price > $highest_price and $bid_price >$starting_price){
        $sql = "INSERT INTO bid (bid_price, time_of_bid, auction_ID, user_ID) VALUES($bid_price, '$time_of_bid', $auction_id, $user_id)";
        if ($conn->query($sql) != TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        } else{
            echo('<div class="text-center">You bid successfully! <a href="mybids.php">View your bids.</a ></div>');
        }
    }else{
        echo('<div class="text-center">You bid unsuccessfully, please set the price above highest price and start price! <a href="listing.php?item_id=' . $auction_id . '">Try again.</a ></div>');
    }
?>