<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
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
          <option value="Furniture">Furniture</option>
          <option value="Jewelry">Jewelry</option>
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

  $query = "SELECT * FROM Auction";
  switch ($ordering) {
    case 'pricelow': 
      $query .= ' ORDER BY maxBidPrice ASC';
      break;
    case 'pricehigh':
      $query .= ' ORDER BY maxBidPrice DESC';
      break;
    case 'date':
      $$query .= ' ORDER BY A1.end_date ASC';
      break;
    // case 'datelate':
    //   $$query .= ' ORDER BY A1.end_date DESC';
    //   break;
  }
  // Retrieve these from the URL
  if ((!isset($_GET['keyword']) && !isset($_GET['cat'])) | (isset($_GET['keyword']) && $_GET['keyword'] == '' && isset($_GET['cat']) && $_GET['cat'] == 'all')) {
    $query = "SELECT * FROM Auction";

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
    $num_results = mysqli_num_rows($items);
    // TODO: Define behavior if a keyword has not been specified.
  }
  elseif (isset($_GET['keyword']) && $_GET['keyword'] == '' && isset($_GET['cat']) && $_GET['cat'] != 'all'){
    $category = $_GET['cat'];
    // $query = "SELECT * FROM auction WHERE category = '$category'";
    $query .= "AND (category = '$category')";
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
    $num_results = mysqli_num_rows($query_run);
  }elseif(isset($_GET['keyword']) && $_GET['keyword'] != '' && isset($_GET['cat']) && $_GET['cat'] == 'all'){
    $keyword = $_GET['keyword'];
    // $query = "SELECT * FROM auction WHERE CONCAT(item_name,description) LIKE '%$keyword%' ";
    $query .= "AND (CONCAT(item_name,description) LIKE '%$keyword%')";
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
    $num_results = mysqli_num_rows($query_run);
  }
  elseif(isset($_GET['keyword']) && $_GET['keyword'] != '' && isset($_GET['cat']) && $_GET['cat'] != 'all'){
    $category = $_GET['cat'];
    // $query = "SELECT * FROM auction WHERE category = $category";
    $keyword = $_GET['keyword'];
    // $query = "SELECT * FROM auction WHERE CONCAT(item_name,description) LIKE '%$keyword%' ";

    // $query = "SELECT * FROM auction WHERE category = '$category' AND CONCAT(item_name, description) LIKE '%$keyword%'";
    $query .= "AND (category = '$category' AND CONCAT(item_name, description) LIKE '%$keyword%')";
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
    $num_results = mysqli_num_rows($query_run);
  }

  // if (!isset($_GET['cat'])) {
  //   // TODO: Define behavior if a category has not been specified.
  // }
  // else {
  //   $category = $_GET['cat'];
  // }
  
  
  
  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

  /* TODO: Use above values to construct a query. Use this query to 
    retrieve data from the database. (If there is no form data entered,
    decide on appropriate default value/default query to make. */
  
  /* For the purposes of pagination, it would also be helpful to know the
    total number of results that satisfy the above query */
  // $num_results = 96; // TODO: Calculate me for real
  $results_per_page = 3;
  $max_page = ceil($num_results / $results_per_page);
?>
<!-- <?php
  $keyword = $_GET['keyword'] ?? "";
  $cat = $_GET['cat'] ?? "all";
  $ordering = $_GET['order_by'] ?? "pricelow";
  $curr_page = $_GET['page'] ?? 1;

  $find_auctions_query = "SELECT A1.auction_Id, A1.item_name, A1.description, SQ.maxBidPrice, SQ.numBids, A1.end_time FROM Auction as A1,
    (SELECT B.auction_Id, MAX(bid_price) as maxBidPrice, COUNT(DISTINCT B.bid_ID) as numBids FROM Auction as A2, Bid as B GROUP BY B.auction_Id) as SQ
    WHERE A1.auction_Id = SQ.auction_Id"; //没bid过的不显示

  // Add keyword filter to SQL query
  $find_auctions_query .= " AND (A1.item_name LIKE '%{$keyword}%' OR A1.description LIKE '%{$keyword}%')";
  // Add category filter to SQL query
  if ($cat != 'all') {
    $find_auctions_query .= " AND (A1.category = '{$cat}')";
  }
  // Add ordering filter to SQL query
  switch ($ordering) {
    case 'pricelow': 
      $find_auctions_query .= ' ORDER BY maxBidPrice ASC';
      break;
    case 'pricehigh':
      $find_auctions_query .= ' ORDER BY maxBidPrice DESC';
      break;
    case 'datesoon':
      $find_auctions_query .= ' ORDER BY A1.end_date ASC';
      break;
    case 'datelate':
      $find_auctions_query .= ' ORDER BY A1.end_date DESC';
      break;
  }

  // Add pagination filter to SQL query
  $query_run = mysqli_query($conn,$find_auctions_query);
  $num_results = mysqli_num_rows($query_run);
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);
  $page_start_index = ($curr_page-1) * $results_per_page;  
  $find_auctions_query .= " LIMIT " . $page_start_index . ',' . $results_per_page;
  
  // Execute Final Query
  // print_h3($find_auctions_query);
  $found_auctions = $query_run;
  while($row = mysqli_fetch_array($found_auctions)) {
    print_listing_li($row['auction_Id'], $row['item_name'], $row['description'], $row['maxBidPrice'], $row['numBids'], $row['end_time']);
  } 
?> -->


<!-- TODO: Use a while loop to print a list item for each auction listing
     retrieved from the query -->

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