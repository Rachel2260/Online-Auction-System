
<?php
// display_time_remaining:
// Helper function to help figure out what time to display
function display_time_remaining($interval) {

    if ($interval->days == 0 && $interval->h == 0) {
      // Less than one hour remaining: print mins + seconds:
      $time_remaining = $interval->format('%im %Ss');
    }
    else if ($interval->days == 0) {
      // Less than one day remaining: print hrs + mins:
      $time_remaining = $interval->format('%hh %im');
    }
    else {
      // At least one day remaining: print days + hrs:
      $time_remaining = $interval->format('%ad %hh');
    }

  return $time_remaining;

}

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_listing_li($item_id, $title, $desc, $price, $num_bids, $end_time)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 1 | $num_bids == 0) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  $end_time_formatted = date_create($end_time);
  if ($now > $end_time_formatted) {
    $time_remaining = 'This auction has ended';
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time_formatted);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }
  
  // Print HTML
  echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
  </li>'
  );
}

function print_listing_li_bid($item_id, $title, $desc, $price, $num_bids, $end_time, $bid_time, $status)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 1) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  $end_time_formatted = date_create($end_time);
  if ($now > $end_time_formatted) {
    $time_remaining = 'This auction has ended';
    $status = $status;
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time_formatted);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
    $status = '';
  }

  // Print HTML
  if ($status == 'You won the auction'){
    echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap">
            <span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>
            ' . $num_bids . $bid . '<br/>
            ' . $time_remaining . '<br/>
            <i style="font-size: 0.8em; color: gray;">last bid at ' . $bid_time . '</i><br/>
            <span style="color: green;">' . $status . '</span>            
    </div>
    </li>');
  }
  elseif ($status == "You didn't win the auction"){
    echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap">
            <span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>
            ' . $num_bids . $bid . '<br/>
            ' . $time_remaining . '<br/>
            <i style="font-size: 0.8em; color: gray;">last bid at ' . $bid_time . '</i><br/>
            <span style="color: red;">' . $status . '</span>            
    </div>
    </li>');
  } else {
    echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap">
            <span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>
            ' . $num_bids . $bid . '<br/>
            ' . $time_remaining . '<br/>
            <i style="font-size: 0.8em; color: gray;">last bid at ' . $bid_time . '</i><br/>                  
    </div>
    </li>');
  }
}



function print_listing_li_auction($item_id, $title, $desc, $price, $num_bids, $end_time, $status)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 1 or $num_bids == 0) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  $end_time_formatted = date_create($end_time);
  if ($now > $end_time_formatted) {
    $time_remaining = 'This auction has ended';
    $status = $status;
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time_formatted);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
    $status = '';
  }

  if ($status == "Successful auction") {
    echo('
      <li class="list-group-item d-flex justify-content-between">
      <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
      <div class="text-center text-nowrap">
              <span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>
              ' . $num_bids . $bid . '<br/>
              ' . $time_remaining . '<br/>
              <span style="color: green;">' . $status . '</span>            
      </div>
      </li>'
    ); 
  } else {
    echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap">
            <span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>
            ' . $num_bids . $bid . '<br/>
            ' . $time_remaining . '<br/>      
              <span style="color: red;">' . $status . '</span>
            
    </div>
    </li>'
    ); 
  }
}

function count_bid($auctionid){
  // Database Connection
  include "db_connection.php";


  $sql = "SELECT COUNT(bid_ID) AS count FROM Bid WHERE auction_ID = $auctionid";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    die("Error in count_bid query: " . mysqli_error($conn));
  }

  if(mysqli_num_rows($result) > 0) {
    if($row = mysqli_fetch_assoc($result)) {
      $count = $row["count"];
    }
  } else {
    echo "No results found in count_bid.";
  }

  return $count;
}

function current_price($auctionid){
  include "db_connection.php";
  

  $sql = "SELECT MAX(bid_price) AS currentPrice FROM Bid WHERE auction_ID = $auctionid";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    die("Error in current_price query: " . mysqli_error($conn));
  }

  if(mysqli_num_rows($result) > 0) {
    if($row = mysqli_fetch_assoc($result)) {
      $currentPrice = $row["currentPrice"]; 
    }
  } else {
    $currentPrice = 0;
  }

  return $currentPrice;
}

function current_shown_price($auctionid){
  include "db_connection.php";
  
  
  $sql_bid = "SELECT MAX(bid_price) AS currentPrice FROM Bid WHERE auction_ID = $auctionid";
  $result_bid = mysqli_query($conn, $sql_bid);

  $sql_start = "SELECT starting_price AS currentPrice FROM Auction WHERE auction_ID = $auctionid";
  $result_start = mysqli_query($conn, $sql_start);

  if (!$result_start) {
    die("Error in starting_price query: " . mysqli_error($conn));
  }

  if (count_bid($auctionid) == 0){
    $result = $result_start;
  } else{
    $result = $result_bid;
  }
  
  $row = mysqli_fetch_assoc($result);
  $currentPrice = $row["currentPrice"]; 
  return $currentPrice;
}

function success_bidder($auctionid){
  include "db_connection.php";
  
  $sql = "SELECT user_ID FROM Bid WHERE bid_price = (SELECT MAX(bid_price) FROM Bid WHERE auction_ID = $auctionid) AND auction_ID = $auctionid";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    die("Error in current_bidder query: " . mysqli_error($conn));
  }

  if(mysqli_num_rows($result) > 0) {
    if($row = mysqli_fetch_assoc($result)) {
      $bidderID = $row["user_ID"]; 
    }
  } else {
    echo "No results found in current_bidder.";
  }

  return $bidderID;
}

//function used for calculatign average rating
function calculate_average_rating($user_ID){
 include "db_connection.php";

 $sql = "SELECT AVG(mark) AS avg_mark
 FROM auction 
 RIGHT JOIN marking ON auction.auction_ID = marking.auction_ID 
 WHERE auction.user_ID = $user_ID;";

 $result =  mysqli_query($conn, $sql);
 if (!$result) {
  die("Error in current_bidder query: " . mysqli_error($conn));
}
if(mysqli_num_rows($result) > 0) {
  if($row = mysqli_fetch_assoc($result)) {
    $avg_mark = $row["avg_mark"];
    if($avg_mark == null){
      echo '<span style="color:lightgray;">No history rating yet.</span>';
    }else{
    return number_format($avg_mark,2);}
  }
} else {
  echo '<span style="color:lightgray;">No history rating yet.</span>';
}
}


?>