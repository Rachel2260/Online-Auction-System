<?php require("utilities.php")?>
<?php include_once("header.php");?>
<?php include "db_connection.php";?>
<div class="container my-5">
<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.

    // include "listing.php";
    $auction_id = $_GET['item_id'];
    $edit_reserve_price = $_POST['reserve_price'];
    $sql_sp = "SELECT starting_price, reserve_price, end_time FROM auction WHERE auction_ID = $auction_id";
    $result = mysqli_query($conn,$sql_sp);
    $row = mysqli_fetch_assoc($result);
    $end_time = new DateTime($row['end_time']);
    $original_reserve_price = $row['reserve_price'];
    $starting_price = $row['starting_price'];
    $current_price =  current_price($auction_id);
    $user_id = $_SESSION["user_ID"];
    $num_bid = count_bid($auction_id);

    $now = new DateTime();
  
    if ($now < $end_time) {
      $time_to_end = date_diff($now, $end_time);
    }

    if ($time_to_end->days >= 2 and $edit_reserve_price >= $starting_price){
        $sql = "UPDATE auction
                SET reserve_price = '$edit_reserve_price'
                WHERE auction_ID = '$auction_id'";
        if ($conn->query($sql) != TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        } else{
            echo('<div class="text-center">You edit successfully <a href="listing.php?item_id=' . $auction_id . '">Go Back.</a ></div>');
        }
    }
    else{
        echo('<div class="text-center">❗️You edit unsuccessfully, please set the reserve price not lower than the starting price. <a href="listing.php?item_id=' . $auction_id . '">Try again.</a >❗️</div>');
    }

?>
