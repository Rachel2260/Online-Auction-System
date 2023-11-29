<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>

<div class="container">


<div class="container mt-5">
<ul class="list-group">
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

  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }
  $results_per_page = 8;
  $start_from = ($curr_page - 1) * $results_per_page;

  $query = "SELECT 
              Bid.bid_price,
              Bid.time_of_bid,
              Bid.auction_ID,
              Auction.item_name,
              Auction.description,
              Auction.end_time,
              Auction.reserve_price
          FROM 
              Bid
          INNER JOIN 
              Auction ON Bid.auction_ID = Auction.auction_ID
          WHERE 
              Bid.user_ID = $user_ID
          ORDER BY 
              Bid.time_of_bid DESC";

  $query_temp = mysqli_query($conn,$query);
  $num_results = mysqli_num_rows($query_temp);

  $query .= " LIMIT " . $start_from . ',' . $results_per_page;
  $query_run = mysqli_query($conn,$query);

  if (mysqli_num_rows($query_run)>0)
  {
    while($row = mysqli_fetch_assoc($query_run)) : 
      $title = $row["item_name"];
      $desc = $row["description"];
      $price = $row['bid_price'];
      $auction_ID = $row["auction_ID"];
      $num_bids = count_bid($auction_ID);
      $end_time = $row["end_time"];
      $reserve_price = $row["reserve_price"];
      $bid_time = $row['time_of_bid'];
      if (success_bidder($auction_ID) == $user_ID and $price >= $reserve_price){
        print_listing_li_bid($auction_ID, $title, $desc, $price, $num_bids, $end_time, $bid_time, 'Successful bidding');
      }
      else{
        print_listing_li_bid($auction_ID, $title, $desc, $price, $num_bids, $end_time, $bid_time, 'Failed bidding');
      }
    endwhile;
  }
  else
  {
    ?>
      <tr>
        <td colspan="4" style="text-align: center;">No record found</td>
      </tr>
    <?php
  }

  $max_page = ceil($num_results / $results_per_page);
  ?>

</ul>

<!-- Pagination for results listings -->
<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">
  
<?php

  // Copy any currently-set GET variables to the URL.
  $querystring = "";
  foreach ($_GET as $key => $value) {
    if ($key != "page") {
      $querystring .= "$key=$value&amp;";
    }
  }
  
  $high_page_boost = max(3 - $curr_page, 0);
  $low_page_boost = max(2 - ($max_page - $curr_page), 0);
  $low_page = max(1, $curr_page - 2 - $low_page_boost);
  $high_page = min($max_page, $curr_page + 2 + $high_page_boost);
  
  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
  }
    
  for ($i = $low_page; $i <= $high_page; $i++) {
    if ($i == $curr_page) {
      // Highlight the link
      echo('
    <li class="page-item active">');
    }
    else {
      // Non-highlighted link
      echo('
    <li class="page-item">');
    }
    
    // Do this in any case
    echo('
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>
</nav>


</div>

<?php include_once("footer.php")?>