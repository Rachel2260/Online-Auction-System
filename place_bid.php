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

    if ($reserve_price && $bid_price < $reserve_price) {
        echo('<div class="text-center">Your bid did not meet the reserve price. <a href="listing.php?item_id=' . $auction_id . '">Try again.</a></div>');
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
    echo('<div class="text-center">Your bid of $' . $bid_price . ' has been placed successfully.</div>');

    // Notify previous highest bidder if outbid
    SendOutbidEmail($conn, $auction_id, $user_id, $bid_price);
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
            $content = '<h3>Dear  '.$prevHighestBidderName. '</h3>'.'<h3>Your bid was outbid, and the current bid price is '. $bid_price .'.</h3>' .'<h3>Don\'t miss the chance to win the bid by placing a new bid!</h3>'. date('Y-m-d H:i:s');
    
            // Now include email.php
            include("SendEmail.php");
        }
    }
}

$bid_price = $_POST['bid_price'];
$auction_id = (int)$_GET['item_id'];
$user_id = $_SESSION["user_ID"];

placeBid($conn, $bid_price, $auction_id, $user_id);

?>