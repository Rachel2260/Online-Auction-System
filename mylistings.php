<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
<div class="container">

<h2 class="my-3">My listings</h2>



</div>
<div class="container mt-5">
<!-- TODO: If result set is empty, print an informative message. Otherwise... -->

<ul class="list-group">
<?php
  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

  $user_ID = $_SESSION['user_ID'];

  $query = "SELECT 
              Auction.auction_ID,
              Auction.item_name,
              Auction.description,
              Auction.reserve_price,
              Auction.end_time
            FROM
              Auction
            WHERE 
              user_ID = $user_ID
            ORDER BY 
              Auction.auction_ID DESC";
  $query_temp = mysqli_query($conn,$query);
  $results_per_page = 6;
  $start_from = ($curr_page - 1) * $results_per_page;
  $num_results = mysqli_num_rows($query_temp);
  $max_page = ceil($num_results / $results_per_page);


  $query .= " LIMIT " . $start_from . ',' . $results_per_page;
  $query_run = mysqli_query($conn,$query);
  if (mysqli_num_rows($query_run)>0)
  {
    while($row = mysqli_fetch_assoc($query_run)) : 
      $auction_id = $row['auction_ID'];
      $title = $row['item_name'];  
      $description = $row['description'];  
      $reserve_price = $row['reserve_price'];
      $current_price = current_shown_price($auction_id);
      $num_bids = count_bid($auction_id);
      $end_date = $row['end_time'];
      if ($current_price >= $reserve_price){
        print_listing_li_auction($auction_ID, $title, $description, $current_price, $num_bids, $end_date, 'Successful auction');
      }else{
        print_listing_li_auction($auction_ID, $title, $description, $current_price, $num_bids, $end_date, 'Failed auction');
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
  
?>


<div class="container mt-5">

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->



<!-- ------------------- PAGINATION UI ------------------- -->
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
  
  // If not first page, show left and right button options 
  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
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