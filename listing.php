<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include "db_connection.php";?>
<?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</p>";
      // Add more user-specific content here
  } else {
      echo "<p>Welcome, guest!</p>";
      // Show login or registration links
  }
?> 

<?php
  
  // Get info from the URL:
  $item_id = $_GET['item_id'];
  $user_ID = $_SESSION['user_ID'];

  $sql_history = "INSERT INTO history (user_ID, auction_ID) VALUES($user_ID, $item_id)";
  if ($conn->query($sql_history) != TRUE) {
      echo "Error: " . $sql_history . "<br>" . $conn->error;
  }


  // TODO: Use item_id to make a query to the database.
  $sql = "SELECT * FROM auction WHERE auction_ID = '$item_id'";
  $result_auction = mysqli_query($conn,$sql);
  $row_auction = mysqli_fetch_assoc($result_auction);
  $title = $row_auction["item_name"];
  $description = $row_auction["description"];
  $current_price = current_price($item_id);
  $num_bids = count_bid($item_id);
  $end_time = new DateTime($row_auction["end_time"]);
  $starting_price = $row_auction["starting_price"];
  $reserve_price = $row_auction["reserve_price"];
  $user_ID_seller = $row_auction["user_ID"];

  //fetch the seller name:
  $sql = "SELECT * FROM user WHERE user_ID = $user_ID_seller";
  $result_auction = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result_auction);
  $seller_name = $row["username"];
  // DELETEME: For now, using placeholder data.


  // TODO: Note: Auctions that have ended may pull a different set of data,
  //       like whether the auction ended in a sale or was cancelled due
  //       to lack of high-enough bids. Or maybe not.
  
  
  // Calculate time to auction end:
  $now = new DateTime();
  
  if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
  }
  
  // TODO: If the user has a session, use it to make a query to the database
  //       to determine if the user is already watching this item.
  //       For now, this is hardcoded.
  
  if(isset($_SESSION['user_ID'])){
    $user_ID = $_SESSION['user_ID'];
    $sql_select = "SELECT * FROM watch WHERE user_ID = $user_ID AND auction_ID = $item_id;";
    $result =  mysqli_query($conn, $sql_select);
    if(mysqli_num_rows($result)>0){
      $watching = true;
    }else{
      $watching = false;
    }
  
    $has_session = true;
  }else{
     echo 'sorry you have log out.';
     $has_session = false;
}
?>


<div class="container">

<div class="row"> <!-- Row #1 with auction title + watch button -->
  <div class="col-sm-8"> <!-- Left col -->
    <h2 class="my-3"><?php echo($title); ?></h2>
  </div>
  
  <div class="col-sm-4 align-self-center"> <!-- Right col -->
<?php
  /* The following watchlist functionality uses JavaScript, but could
     just as easily use PHP as in other places in the code */
  if ($now < $end_time):
?>
    <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
    </div>
    <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
      <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
    </div>
<?php endif /* Print nothing otherwise */ ?>
  </div>
</div>

<div class="row"> <!-- Row #2 with auction description + bidding info -->
  <div class="col-sm-8"> <!-- Left col with item info -->

    <div class="itemDescription">
    <?php echo($description); ?>
    </div>
    
  </div>

  <div class="col-sm-4"> <!-- Right col with bidding info -->

    <p>
<?php if ($now > $end_time): ?>
     This auction ended <?php echo(date_format($end_time, 'j M H:i')).'</br>' ?>
     <!-- TODO: Print the result of the auction here? -->
     <?php 
      if($reserve_price <= current_price($item_id)){
         $winner = success_bidder($item_id);
         //不做判断了不知道如果我现价比reserve_price高的话怎么会没有winner
         //find username with userid
         $sql = "SELECT username FROM user WHERE user_ID = $winner";
         $result =  mysqli_query($conn, $sql);
         if($result){
          $row = mysqli_fetch_assoc($result);
          $username_fetch = $row["username"];
         } else{
          echo "error_connection" . mysqli_connect_error();
         }
         echo 'Result: the auction is successfully bid by '.$username_fetch.' at price equals '.current_price($item_id).'</br>';
         //  marking record:
         if (isset($_SERVER['HTTP_REFERER']) && ((strpos($_SERVER['HTTP_REFERER'], 'mybids.php') !== false)||(strpos($_SERVER['HTTP_REFERER'], 'marking.php') !== false))) {
          //判断是不是这个人success
          if($_SESSION["user_ID"]==$winner){
            //判断有没有已经评价过了
            $sql_select_marking = "SELECT mark FROM marking WHERE auction_ID = 28 AND user_ID = 22;";
            $result_test = mysqli_query($conn, $sql_select_marking);
            if(mysqli_num_rows($result_test)==0){
              echo '<div class = "col-10">
              <button type="button" class="btn btn-primary form-control custom_2" data-toggle="modal" data-target="#rating">rating for seller!</button>
              </div>';
            }else{
              echo '<span style="color: green;">Thank you for your marking!</span>';
            }
          }
          
        }

      }else{
        if(current_price($item_id)==0){
          echo 
          'Result: the auction failed as there is no matching buyers';
        }else{
          echo "Result: the auction failed as not reaching the reserved price";
        }

      }?>



<?php else: ?>
     Auction ends <?php echo(date_format($end_time, 'j M H:i') . $time_remaining) ?></p>  
    <p class="lead">Starting price: £<?php echo(number_format($starting_price, 2)) ?></p>
    <p class="lead">Current bid: £<?php echo(number_format($current_price, 2)) ?></p>

    <!-- Bidding form -->
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] != 'seller'): ?>
      <form method="POST" action="place_bid.php?item_id=<?php echo "$item_id"; ?>">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">£</span>
          </div>
        <input type="number" class="form-control" id="bid_price" name = "bid_price">
        </div>
        <button type="submit" class="btn btn-primary form-control">Place bid</button>
      </form>
    <?php endif ?> 
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'seller'): ?>
      <p class="lead">Reserve price: £<?php echo(number_format($reserve_price, 2)) ?></p>
      <?php if ($time_to_end->days >= 2): ?>
        <form method="POST" action="edit_reserve_price.php?item_id=<?php echo "$item_id"; ?>">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">£</span>
            </div>
          <input type="number" class="form-control" id="bid_price" name = "reserve_price" placeholder="No lower than the starting price">
          </div>
          <button type="submit" class="btn btn-primary form-control">Edit reserve price</button>
        </form>
      <?php else: ?>
        <div style="font-style: italic; font-size: small; color: grey;">
          Unable to edit the reserve price within 48 hours before the auction ends.
        </div>
      <?php endif ?>
    <?php endif ?> 
<?php endif ?>
</div> <!-- End of right col with bidding info -->

</div> <!-- End of row #2 -->


<div class="container">

<div class="row"> <!-- Row #1 with auction title + watch button -->
  <div class="col-sm-8"> <!-- Left col -->
  <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title text-info">auction information</h5>
    <h6 class="card-subtitle mb-2 ">seller information</h6>
    <p class="card-text text-muted">seller name:<?php echo $seller_name;?></p>
    <p class="card-text text-muted">history average rating score:<?php echo calculate_average_rating($user_ID_seller);?></p>
  </div>
</div>
  </div>

  
  <div class="col-sm-4 align-self-center"> <!-- Right col -->
  <!-- Bid History Table -->
  <?php if (count_bid($item_id) > 0):?>
  <!-- Add empty lines -->
  <br>

  <?php
  $query = "SELECT bid_price, time_of_bid FROM Bid WHERE auction_ID = $item_id ORDER BY time_of_bid DESC";
  $result = mysqli_query($conn, $query);
  ?>

  <div style="max-height: 300px; overflow-y: auto;">
  <table class="table">
      <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
          <tr>
              <th>Bid Price</th>
              <th>Bid Time</th>
          </tr>
      </thead>
      <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                  <td>£<?php echo number_format($row['bid_price'], 2); ?></td>
                  <td><?php echo $row['time_of_bid']; ?></td>
              </tr>
          <?php endwhile; ?>
      </tbody>
  </table>
  <?php endif ?>
  <!-- End of Bid History Table -->
  </div>
</div>

</div>



<?php include_once("footer.php")?>


<script> 
// JavaScript functions: addToWatchlist and removeFromWatchlist.

function addToWatchlist(button) {
  console.log("These print statements are helpful for debugging btw");

  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'add_to_watchlist', arguments: [<?php echo($item_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
  
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_nowatch").hide();
          $("#watch_watching").show();
        }
        else {
          var mydiv = document.getElementById("watch_nowatch");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func

function removeFromWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($item_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_watching").hide();
          $("#watch_nowatch").show();
        }
        else {
          var mydiv = document.getElementById("watch_watching");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func
</script>


<!-- rating table -->
<div class="modal fade" id="rating">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">rating for the seller</h4>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="POST" action="marking.php">
            <div class="form-group">
              <input type="hidden" name="item_ID" value=<?php echo $item_id?>>
              <label for="mark">Rating from 1 to 5, where 5 represents the highest level of satisfaction</label>
              <input type="radio" name="rating" id=mark value="1"> 1
              <input type="radio" name="rating" id=mark value="2"> 2
              <input type="radio" name="rating" id=mark value="3"> 3
              <input type="radio" name="rating" id=mark value="4"> 4
              <input type="radio" name="rating" id=mark value="5"> 5
            </div>
            <button type="submit" class="btn btn-primary form-control">submit</button>
          </form>
        </div>

      </div>
    </div>
  </div> <!-- End modal -->
  </div>

  