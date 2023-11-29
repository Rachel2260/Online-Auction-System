<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php"?>
<div class="container">

<!-- after login: show user_specific information-->

<?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</p>";
      // Add more user-specific content here
  } else {
      echo "<p>Welcome, guest!</p>";
      // Show login or registration links
  }
?> 

<h2 class="my-3">Browse listings</h2>

<div id="searchSpecs">
<!-- When this form is submitted, this PHP page is what processes it.
     Search/sort specs are passed to this page through parameters in the URL
     (GET method of passing data to a page). -->
<form method="get" action="browse.php">
  <div class="row">
    <div class="col-md-5 pr-0">
      <div class="form-group">
        <label for="keyword" class="sr-only">Search keyword:</label>
	    <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent pr-0 text-muted">
              <i class="fa fa-search"></i>
            </span>
          </div>
          <input type="text" class="form-control border-left-0" id="keyword" name = 'keyword' value = "<?php if (isset($_GET['keyword'])){echo $_GET['keyword'];}?>" placeholder="Search for anything">
        </div>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-group">
        <label for="cat" class="sr-only">Search within:</label>
        <select class="form-control" id="cat" name = 'cat'>
          <option selected value="all">All categories</option>
          <option value="Antiques">Antiques</option>
          <option value="Art">Art</option>
          <option value="Jewelry">Jewelry</option>
          <option value="Vehicles">Vehicles</option>
          <option value="Electronics">Electronics</option>
          <option value="Others">Others</option>
        </select>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-inline">
        <label class="mx-2" for="order_by">Sort by:</label>
        <select class="form-control" id="order_by" name = 'order_by'>
          <option selected value="pricelow">Price (low to high)</option>
          <option value="pricehigh">Price (high to low)</option>
          <option value="date">Soonest expiry</option>
        </select>
      </div>
    </div>
    <div class="col-md-1 px-0">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>
</form>
</div> <!-- end search specs bar -->


</div>


<div class="container mt-5">

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->

<ul class="list-group">
<?php
  if (!isset($_GET['order_by'])) {
    $ordering = 'pricelow';
  }
  else {
    $ordering = $_GET['order_by'];
  }
  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }
  $results_per_page = 5;
  $start_from = ($curr_page - 1) * $results_per_page;
  

  // Retrieve these from the URL
  if ((!isset($_GET['keyword']) && !isset($_GET['cat'])) | (isset($_GET['keyword']) && $_GET['keyword'] == '' && isset($_GET['cat']) && $_GET['cat'] == 'all')) {
    $query = "SELECT * FROM Auction";
    if ($ordering == 'pricelow'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price ASC";
    }
    elseif ($ordering == 'pricehigh'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price DESC";
    }
    elseif ($ordering == 'date'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    auction.end_time ASC";
    }
    $query_temp = mysqli_query($conn,$query);
    $num_results = mysqli_num_rows($query_temp);

    $query .= " LIMIT " . $start_from . ',' . $results_per_page;
    $query_run = mysqli_query($conn,$query);

    if(mysqli_num_rows($query_run) == 0){
      echo"There is no aution.";
      exit();
    }
    elseif(!$query_run){
      die("Error in auction query: " . mysqli_error($conn));
    }

    while($row = mysqli_fetch_assoc($query_run)) : 
      $item_id = $row['auction_ID'];
      $title = $row['item_name'];  
      $description = $row['description'];  
      $current_price = current_shown_price($item_id);
      $num_bids = count_bid($item_id);
      $end_date = $row['end_time'];
      print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
    endwhile;

    // TODO: Define behavior if a keyword has not been specified.
  }elseif (isset($_GET['keyword']) && $_GET['keyword'] == '' && isset($_GET['cat']) && $_GET['cat'] != 'all'){
    $category = $_GET['cat'];
    if ($ordering == 'pricelow'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price ASC";
    }
    elseif ($ordering == 'pricehigh'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price DESC";
    }
    elseif  ($ordering == 'date'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    auction.end_time ASC";
    }
    $query_temp = mysqli_query($conn,$query);
    $num_results = mysqli_num_rows($query_temp);

    $query .= " LIMIT " . $start_from . ',' . $results_per_page;
    $query_run = mysqli_query($conn,$query);
    if (mysqli_num_rows($query_run)>0)
    {
      while($row = mysqli_fetch_assoc($query_run)) : 
        $item_id = $row['auction_ID'];
        $title = $row['item_name'];  
        $description = $row['description'];  
        $current_price = current_shown_price($item_id);
        $num_bids = count_bid($item_id);
        $end_date = $row['end_time'];
        print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
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

  }elseif(isset($_GET['keyword']) && $_GET['keyword'] != '' && isset($_GET['cat']) && $_GET['cat'] == 'all'){
    $keyword = $_GET['keyword'];
    if ($ordering == 'pricelow'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price ASC";
    }
    elseif ($ordering == 'pricehigh'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price DESC";
    }
    elseif ($ordering == 'date'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    auction.end_time ASC";
    }
    $query_temp = mysqli_query($conn,$query);
    $num_results = mysqli_num_rows($query_temp);

    $query .= " LIMIT " . $start_from . ',' . $results_per_page;
    $query_run = mysqli_query($conn,$query);
    if (mysqli_num_rows($query_run)>0)
    {
      while($row = mysqli_fetch_assoc($query_run)) : 
        $item_id = $row['auction_ID'];
        $title = $row['item_name'];  
        $description = $row['description'];  
        $current_price = current_shown_price($item_id);
        $num_bids = count_bid($item_id);
        $end_date = $row['end_time'];
        print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
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

  }
  elseif(isset($_GET['keyword']) && $_GET['keyword'] != '' && isset($_GET['cat']) && $_GET['cat'] != 'all'){
    $category = $_GET['cat'];
    $keyword = $_GET['keyword'];
    if ($ordering == 'pricelow'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category' AND CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price ASC";
    }
    elseif ($ordering == 'pricehigh'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category' AND CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    max_price DESC";
    }
    elseif ($ordering == 'date'){
      $query = "SELECT 
                auction.auction_ID,
                auction.item_name,
                auction.description,
                auction.category,
                auction.end_time,
                GREATEST(auction.starting_price, COALESCE(MAX(bid.bid_price), 0)) AS max_price
                FROM 
                    auction
                LEFT JOIN 
                    bid ON auction.auction_ID = bid.auction_ID
                WHERE
                    auction.category = '$category' AND CONCAT(auction.item_name, auction.description) LIKE '%$keyword%'
                GROUP BY 
                    auction.auction_ID, auction.item_name, auction.description, auction.category, auction.starting_price, auction.end_time
                ORDER BY
                    auction.end_time ASC";
    }
    $query_temp = mysqli_query($conn,$query);
    $num_results = mysqli_num_rows($query_temp);

    $query .= " LIMIT " . $start_from . ',' . $results_per_page;
    $query_run = mysqli_query($conn,$query);

    if (mysqli_num_rows($query_run)>0)
    {
      while($row = mysqli_fetch_assoc($query_run)) : 
        $item_id = $row['auction_ID'];
        $title = $row['item_name'];  
        $description = $row['description'];  
        $current_price = current_shown_price($item_id);
        $num_bids = count_bid($item_id);
        $end_date = $row['end_time'];
        print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
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

  }

  

  /* TODO: Use above values to construct a query. Use this query to 
    retrieve data from the database. (If there is no form data entered,
    decide on appropriate default value/default query to make. */
  
  /* For the purposes of pagination, it would also be helpful to know the
    total number of results that satisfy the above query */
  $max_page = ceil($num_results / $results_per_page);
?>

<!-- TODO: Use a while loop to print a list item for each auction listing
     retrieved from the query -->

<?php
 

  $sql = "SELECT * FROM Auction";
  $items = mysqli_query($conn,$sql);
  $row_num = mysqli_num_rows($items);
  if(mysqli_num_rows($items) == 0){
    echo"There is no aution.";
    exit();
  }
  elseif(!$items){
    die("Error in auction query: " . mysqli_error($conn));
  }

  while($row = mysqli_fetch_assoc($items)) : 
    $item_id = $row['auction_ID'];
    $title = $row['item_name'];  
    $description = $row['description'];  
    $current_price = current_price($item_id);
    $num_bids = count_bid($item_id);
    $end_date = $row['end_time'];
    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
  endwhile;
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
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
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