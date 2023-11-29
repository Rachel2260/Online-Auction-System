<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
<div class="container">

<h2 class="my-3">Recommendations for you</h2>


<?php
  // This page is for showing a buyer recommended items based on their bid 
  // history. It will be pretty similar to browse.php, except there is no 
  // search bar. This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
 
  //select the required auctionID
  // TODO: Check user's credentials (cookie/session).
  //check the login status and get the user_ID
  if(!isset($_SESSION['user_ID'])){
    echo '<h3 class = "my-3"> You have logged out</h3>';
  }else{
    $user_ID = $_SESSION['user_ID'];
    echo'<br>
    <h3 class="my-3"> The most popular bids</h3>';
  
    // create the general recommendation
    // present 5 most popular bids
    $sql = "SELECT auction.auction_ID , count(bid_ID)as bidnum, auction.end_time
    From bid LEFT JOIN auction ON bid.auction_ID = auction.auction_ID
    GROUP by bid.auction_ID
    having auction.end_time > CURRENT_TIME
    Order by bidnum DESC;";

    $result = mysqli_query($conn,$sql);
    $recommend_list_general = array();
    if($result){
      if(mysqli_num_rows($result)>0){
        $count = 0;
        while(($row = mysqli_fetch_assoc($result)) && $count < 5){
          $auction = $row["auction_ID"];
          array_push($recommend_list_general,$auction);
          $count++;
      }
    }
    foreach($recommend_list_general as $pop_auction_id){
      $sql_find_pop_auction = "SELECT * FROM auction WHERE auction_ID = '$pop_auction_id'";
      $result_auction = mysqli_query($conn,$sql_find_pop_auction);
      $row_auction = mysqli_fetch_assoc($result_auction);
      $title = $row_auction["item_name"];
      $desc = $row_auction["description"];
      $price = current_price($pop_auction_id);
      $num_bids = count_bid($pop_auction_id);
      $end_time = $row_auction["end_time"];
      print_listing_li($pop_auction_id, $title, $desc, $price, $num_bids, $end_time);
    }
  }

  // TODO: Perform a query to pull up auctions they might be interested in.
  echo '<br>
   <h3 class="my-3">Your Personalized recommendation</h3>';
  // I am not sure why this does not work combined but work saparately.
  $sql = "CREATE TEMPORARY TABLE recommendation (auction_ID INT,user_ID INT);";
  $sql_creation = "INSERT INTO recommendation (auction_ID, user_ID)
  SELECT DISTINCT auction_ID, user_ID FROM `bid` WHERE user_ID IN (SELECT user_ID FROM bid WHERE auction_ID in ( SELECT auction_ID FROM bid WHERE user_ID = 22));";
  
  $sql_delete="DELETE FROM recommendation WHERE auction_ID IN (SELECT auction_ID FROM bid WHERE user_ID = 22);";
  $sql_delete_2="
  DELETE FROM recommendation WHERE auction_ID IN (SELECT auction_ID FROM auction WHERE end_time < CURRENT_TIME);";

  $sql_query = "SELECT DISTINCT auction_ID FROM (SELECT auction_ID FROM recommendation UNION SELECT auction_ID FROM watch WHERE user_ID = 22) AS combined_result
  LIMIT 5;";
  mysqli_query($conn,$sql);
  mysqli_query($conn,$sql_creation);
  mysqli_query($conn,$sql_delete);
  mysqli_query($conn,$sql_delete_2);
  $result_auctionid = mysqli_query($conn,$sql_query);
  
  if(!$result_auctionid){
    echo "connection error";
  }
  
  $recommend_list = array();
  if(mysqli_num_rows($result_auctionid)>0){
      while($row = mysqli_fetch_assoc($result_auctionid)){
          $auction_new = $row["auction_ID"];
          array_push($recommend_list,$auction_new); }
  }else{
        echo "not yet shopping";
  }
  
  $sql_drop = "DROP TABLE recommendation";
  $result_drop = mysqli_query($conn, $sql_drop);
  if (!$result_drop) {
    echo "Error dropping temporary table: " . mysqli_error($conn);
    exit;
}

  
  // TODO: Loop through results and print them out as list items.
  $recommend_list_length = count($recommend_list);
  foreach($recommend_list as $auction_id_each){
    $sql_find_auction = "SELECT * FROM auction WHERE auction_ID = '$auction_id_each'";
    $result_auction = mysqli_query($conn,$sql_find_auction);
    $row_auction = mysqli_fetch_assoc($result_auction);
    $title = $row_auction["item_name"];
    $desc = $row_auction["description"];
    $price = current_price($auction_id_each);
    $num_bids = count_bid($auction_id_each);
    $end_time = $row_auction["end_time"];
    print_listing_li($auction_id_each, $title, $desc, $price, $num_bids, $end_time);
  }

  $conn->close();
}

?>