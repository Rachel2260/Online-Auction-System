<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>

<div class="container">

<h2 class="my-3">My bids</h2>

<?php
  // This page is for showing a user the auctions they've bid on.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  



  // TODO: Check user's credentials (cookie/session).

  // TODO: Perform a query to pull up the auctions they've bidded on.

  // TODO: Loop through results and print them out as list items.

  $user_ID = $_SESSION['user_ID'];

  $sql = "SELECT auction_ID FROM Bid WHERE user_ID = $user_ID";
  $result_auctionid = mysqli_query($conn,$sql);
  $auction_list = array();
  if(mysqli_num_rows($result_auctionid)>0){
    while($row = mysqli_fetch_assoc($result_auctionid)){
      $auction_new = $row["auction_ID"];
      array_push($auction_list,$auction_new);
    }
    $auction_list = array_unique($auction_list);
  }else{
      echo "No bid found.";
  }

  $acution_list_length = count($auction_list);
  foreach($auction_list as $auction_id_each){
    $sql_find_auction = "SELECT * FROM auction WHERE auction_ID = '$auction_id_each'";
    $result_auction = mysqli_query($conn,$sql_find_auction);
    $row_auction = mysqli_fetch_assoc($result_auction);

    $sql_bid = "SELECT bid_ID FROM Bid WHERE user_ID = $user_ID and auction_ID = '$auction_id_each'";
    $result_bid = mysqli_query($conn,$sql_bid);
    $bidid_list = array();
    if(mysqli_num_rows($result_bid)>0){
      while($row = mysqli_fetch_assoc($result_bid)){
        $bidid_new = $row["bid_ID"];
        array_push($bidid_list,$bidid_new); 
      }
    }else{
        echo "No bid found.";
    }
    rsort($bidid_list);
    foreach($bidid_list as $bid_id_each){
      $sql_bidinfo = "SELECT bid_price, time_of_bid FROM Bid WHERE bid_ID = $bid_id_each";
      $result_bidinfo = mysqli_query($conn,$sql_bidinfo);
      $row_bidinfo = mysqli_fetch_assoc($result_bidinfo);
      $title = $row_auction["item_name"];
      $desc = $row_auction["description"];
      $price = $row_bidinfo['bid_price'];
      $num_bids = count_bid($auction_id_each);
      $end_time = $row_auction["end_time"];
      $reserve_price = $row_auction["reserve_price"];
      $bid_time = $row_bidinfo['time_of_bid'];
      if (success_bidder($auction_id_each) == $user_ID and $price >= $reserve_price){
        print_listing_li_success($auction_id_each, $title, $desc, $price, $num_bids, $end_time, $bid_time);
      }
      else{
        print_listing_li_fail($auction_id_each, $title, $desc, $price, $num_bids, $end_time, $bid_time);
      }
    }
  }

  $conn->close();
?>

<?php include_once("footer.php")?>