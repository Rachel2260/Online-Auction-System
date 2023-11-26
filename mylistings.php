<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
<div class="container">

<h2 class="my-3">My listings</h2>

<?php
  // This page is for showing a user the auction listings they've made.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.

  // TODO: Check user's credentials (cookie/session).
  
  // TODO: Perform a query to pull up their auctions.
  
  // TODO: Loop through results and print them out as list items.
  
  $user_ID = $_SESSION['user_ID'];
  $sql = "SELECT auction_ID FROM Auction WHERE user_ID = $user_ID";
  $result_auctionid = mysqli_query($conn,$sql);
  $auction_list = array();
  if(mysqli_num_rows($result_auctionid)>0){
    while($row = mysqli_fetch_assoc($result_auctionid)){
        $auction_new = $row["auction_ID"];
        array_push($auction_list,$auction_new); }
  }else{
      echo "No auction found.";
  }

  $acution_list_length = count($auction_list);
  foreach($auction_list as $auction_id_each){
    $sql_find_auction = "SELECT * FROM auction WHERE auction_ID = '$auction_id_each'";
    $result_auction = mysqli_query($conn,$sql_find_auction);
    $row_auction = mysqli_fetch_assoc($result_auction);
    $title = $row_auction["item_name"];
    $desc = $row_auction["description"];
    $price = current_shown_price($auction_id_each);
    $num_bids = count_bid($auction_id_each);
    $end_time = $row_auction["end_time"];
    print_listing_li($auction_id_each, $title, $desc, $price, $num_bids, $end_time);
  }

  $conn->close();
?>

<?php include_once("footer.php")?>