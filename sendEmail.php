<!-- contain code for sending emails -->
<!-- database connection -->
<?php include "db_connection.php";?>



<!-- send email function -->
<?php

// send the outbid notification
// $recipientEmail: The email address of the user who was outbid.
// $itemName: The name of the auction item.
// $currentBid: The current highest bid for the item
function send_outbid_notification($recipientEmail, $itemName, $currentBid) {
    $subject = "You've been outbid on $itemName!";
    $message = "Hello,\n\nYou have been outbid on the item '$itemName'. The current highest bid is now $$currentBid.\n\nPlease visit our site to place a new bid if you're still interested.";
    $headers = 'From: noreply@quickauctionsite.com';

    if(mail($recipientEmail, $subject, $message, $headers)) {
        echo "Notification sent to $recipientEmail";
    } else {
        echo "Failed to send notification". error_get_last()['message'];;
    }
}

// send winning bid notification
function send_winning_bid_notification($recipientEmail, $itemName, $winningBid) {
    $subject = "Congratulations! You've won $itemName!";
    $message = "Hello,\n\nCongratulations! You have won the item '$itemName' with a bid of $$winningBid.\n\nPlease visit our site to complete the purchase.";
    $headers = 'From: noreply@quickauctionsite.com';

    if(mail($recipientEmail, $subject, $message, $headers)) {
        echo "Winning bid notification sent to $recipientEmail";
    } else {
        echo "Failed to send winning bid notification. " . error_get_last()['message'];
    }
}

//extra: send auction start notification
function send_auction_start_notification($recipientEmail, $itemName, $startBid) {
    $subject = "Auction Started for $itemName!";
    $message = "Hello,\n\nAn auction for '$itemName' has just started with a starting bid of $$startBid.\n\nVisit our site to place your bid!";
    $headers = 'From: noreply@quickauctionsite.com';

    if(mail($recipientEmail, $subject, $message, $headers)) {
        echo "Auction start notification sent to $recipientEmail";
    } else {
        echo "Failed to send auction start notification. " . error_get_last()['message'];
    }
}

//extra: send auction end notification
function send_auction_reminder($recipientEmail, $itemName, $timeRemaining) {
    $subject = "Auction Ending Soon for $itemName!";
    $message = "Hello,\n\nThe auction for '$itemName' is ending in $timeRemaining. Don't miss your chance to bid!\n\nVisit our site to place your bid!";
    $headers = 'From: noreply@quickauctionsite.com';

    if(mail($recipientEmail, $subject, $message, $headers)) {
        echo "Auction reminder sent to $recipientEmail";
    } else {
        echo "Failed to send auction reminder. " . error_get_last()['message'];
    }
}

?>
