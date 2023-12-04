<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php require("utilities.php")?>
<?php include_once("header.php");?>
<?php include "db_connection.php";?>

<div class="container my-5">
<?php

function placeBid($conn, $bid_price, $auction_id, $user_id) {
    $highest_price = current_price($auction_id);

    // Fetch starting and reserve price from the database
    $sql = "SELECT starting_price, reserve_price FROM auction WHERE auction_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $auction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        echo "No data found for auction ID: $auction_id";
        return;
    }

    $starting_price = $row['starting_price'];
    $reserve_price = $row['reserve_price'];

    // Validate bid
    if ($bid_price <= $highest_price || $bid_price < $starting_price) {
        echo('<div class="text-center">Your bid was unsuccessful. Please set the price above the highest price and starting price! <a href="listing.php?item_id=' . $auction_id . '">Try again.</a></div>');
        return;
    }

    // Insert the bid into the database
    $time_of_bid = date('Y-m-d H:i:s');
    $insertSql = "INSERT INTO bid (bid_price, time_of_bid, auction_ID, user_ID) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("isii", $bid_price, $time_of_bid, $auction_id, $user_id);
    if (!$insertStmt->execute()) {
        echo "Error inserting bid: " . $conn->error;
        return;
    }

    // Bid was successfully placed
    echo('<div class="text-center">Your bid of $' . $bid_price . ' has been placed successfully. <a href="mybids.php">View your bids.</a></div>');

    // Notify previous highest bidder if outbid
    SendOutbidEmail($conn, $auction_id, $user_id, $bid_price);

    SendBidUpdateEmail($conn, $auction_id, $bid_price);
}

function SendOutbidEmail($conn, $auction_id, $user_id, $bid_price) {
    $sql = "SELECT user_ID FROM Bid WHERE auction_ID = ? AND user_ID != ? ORDER BY bid_price DESC, time_of_bid DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $auction_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $prevHighestBidderId = $row['user_ID'];

        // Retrieve the email of the previous highest bidder
        $sql = "SELECT email, username FROM User WHERE user_ID = ?";
        $userStmt = $conn->prepare($sql);
        $userStmt->bind_param("i", $prevHighestBidderId);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        if ($userRow = $userResult->fetch_assoc()) {
            $prevHighestBidderEmail = $userRow['email'];
            $prevHighestBidderName = $userRow['username'];
            // Set email variables
            $email = $prevHighestBidderEmail;
            $receiver = $prevHighestBidderName;
            $email_title = 'Your bid (Auction ID: '.$auction_id. ') was outbid!';
            $content = '<h3>Dear  '.$prevHighestBidderName. '</h3>'.'<h3>Your bid was outbid, and the current bid price is £ '. $bid_price .'.</h3>' .'<h3>Don\'t miss the chance to win the bid by placing a new bid!</h3>'. date('Y-m-d H:i:s');
    
            // Now include email.php
            include("SendEmail.php");
        }
    }
}

$bid_price = $_POST['bid_price'];
$auction_id = (int)$_GET['item_id'];
$user_id = $_SESSION["user_ID"];

placeBid($conn, $bid_price, $auction_id, $user_id);

//send  email  to  users when a new bid is placed on their watchlist auction
//user who add auction to watch list will get their bid update automatically
//$conn database connection
//$bid_price (the price of the new bid).
function SendBidUpdateEmail($conn, $auction_id, $bid_price) {

    //who to sent email:  Fetch the list of users have watchlist 
    //? is placeholder, The exact value is not specified in the query itself but is bound to the placeholder ? later in the code using a method like bind_param.
    $sql = "SELECT u.email, u.username 
            FROM User u 
            INNER JOIN watch w ON u.user_ID = w.user_ID 
            WHERE w.auction_ID = ?";
     //prepare SQL statement       
    $stmt = $conn->prepare($sql);
    //bind the parameter to the placeholder
    $stmt->bind_param("i", $auction_id);
    //execute the prepared statement
    $stmt->execute();
    //get the result: user who have watchlist
    $result = $stmt->get_result();

    // Fetch item details for the email content
    $itemDetails = GetAuctionDetails($conn, $auction_id); 

    while ($user = $result->fetch_assoc()) {
        // Prepare email content for each user
        $email = $user['email']; // Email address of the recipient
        $receiver = $user['username']; // Name of the recipient
        $email_title = "Bid Update on Item You're Watching"; // Subject of the email
        $content = $content = "Dear ,\n\n" .
        "A new bid of £$bid_price has been placed on an item in your watch list: " . $itemDetails['description'] . ".\n\n" .
        "Don't miss the chance to win the bid by placing a new bid!";
        $content = '<h3>Dear  '.$receiver. '</h3>'.'<h3> A new bid has been placed on an item in your watch list: '. $itemDetails['description']  ."\n\n".'</h3>' .'<h3>Not miss the chance to win the bid by placing a new bid! </h3>';
        // Include the email sending script
        include("SendEmail.php");
    }
}

function GetAuctionDetails($conn, $auction_id) {
    // Prepare the SQL query to fetch details of the auction
    $sql = "SELECT item_name, description, starting_price, end_time FROM auction WHERE auction_ID = ?";
    $stmt = $conn->prepare($sql);

    // Check for preparation error
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the auction ID to the prepared statement
    $stmt->bind_param("i", $auction_id);

    // Execute the query
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Fetch the auction details
    $details = $result->fetch_assoc();

    // Return the details
    return $details;
}



?>