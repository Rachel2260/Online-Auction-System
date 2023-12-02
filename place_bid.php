
<?php require("utilities.php")?>
<?php include_once("header.php");?>
<?php include "db_connection.php";?>
<?php include "sendEmail.php";?>
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
    $starting_price
     = $row[0];
    $user_id = $_SESSION["user_ID"];
    
    $time_of_bid = date('Y-m-d h:i:s', time());

    if ($bid_price !=NULL and $bid_price > $highest_price and $bid_price >=$starting_price){
        $sql = "INSERT INTO bid (bid_price, time_of_bid, auction_ID, user_ID) VALUES($bid_price, '$time_of_bid', $auction_id, $user_id)";
        if ($conn->query($sql) != TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        } else {

            // send the email for outbid notification

            //retrieve necessary paramter for email_outbid function
            // Retrieve the item name from the Auction table
            $itemNameQuery = "SELECT item_name FROM Auction WHERE auction_ID = $auction_id";
            $itemNameResult = mysqli_query($conn, $itemNameQuery);
            $itemNameRow = mysqli_fetch_assoc($itemNameResult);
            $itemName = $itemNameRow['item_name'];
    
            // Retrieve the previous highest bidder's user ID
            $sql = "SELECT user_ID FROM Bid WHERE auction_ID = $auction_id AND user_ID != $user_id ORDER BY bid_price DESC, time_of_bid DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $prevHighestBidderId = $row['user_ID'];
                
                // Check if the previous highest bidder is not the current bidder
                if ($prevHighestBidderId != $user_id) {
                    // Retrieve the email of the previous highest bidder
                    $sql = "SELECT email FROM User WHERE user_ID = $prevHighestBidderId";
                    $result = mysqli_query($conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $prevHighestBidderEmail = $row['email'];
    
                        // Send the outbid notification email
                        send_outbid_notification($prevHighestBidderEmail, $itemName, $bid_price);
                    }
                }
            }
    
            echo('<div class="text-center">You bid successfully! <a href="mybids.php">View your bids.</a></div>');
        }
    } else {
        echo('<div class="text-center">❗️Your bid was unsuccessful, please set the price above the highest price and starting price! <a href="listing.php?item_id=' . $auction_id . '">Try again.</a>❗️</div>');
    }
?>

