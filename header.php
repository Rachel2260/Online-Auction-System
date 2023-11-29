<?php
session_start();
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap and FontAwesome CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom CSS file -->
  <link rel="stylesheet" href="css/custom.css">

  <title>[My Auction Site] <!--CHANGEME!--></title>
</head>


<body>

  <!-- Navbars -->
    <!-- changed :  show log out instead of log in when user logged in -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mx-2">
    <a class="navbar-brand" href="#">Quick Auction</a>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <?php

          echo '<button type="button"  class="btn nav-link" data-toggle="modal" data-target="#infoModal">Auction Guides</button>';
      
        ?>
      </li>
      <li class="nav-item">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          echo '<a class="nav-link" href="logout.php">Logout</a>';
        } else {
          echo '<button type="button" class="btn nav-link" data-toggle="modal" data-target="#loginModal">Login</button>';
        }
        ?>
      </li>

    </ul>
  </nav>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav align-middle">
      <li class="nav-item mx-1">
        <a class="nav-link" href="browse.php">Browse</a>
      </li>
      <?php
      if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'buyer') {
        echo ('
	<li class="nav-item mx-1">
      <a class="nav-link" href="mybids.php">My Bids</a>
    </li>
	<li class="nav-item mx-1">
      <a class="nav-link" href="recommendations.php">Recommended</a>
    </li>');
      }
      if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'seller') {
        echo ('
	<li class="nav-item mx-1">
      <a class="nav-link" href="mylistings.php">My Listings</a>
    </li>
	<li class="nav-item ml-3">
      <a class="nav-link btn border-light" href="create_auction.php">+ Create auction</a>
    </li>');
      }
      ?>
    </ul>
  </nav>

  <!-- Information modal -->
  <div class="modal" id="infoModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- modal header -->
        <div class="modal-header">
          <h4 class="modal-title">Auction Guides</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- modal body -->
        <div class="modal-body">
          <p>
          All users must register and create an account before placing bids or creating auction.<br><br>
          <span style="font-size: larger;"><strong>Seller:</strong></span><br>
          <strong>Setting Auction:</strong><br>
          Users can set a reserve price, a minimum price that must be met for the item to be sold. The reserve price can be edited within <span style="color: red;">48 hours</span> before the end date of the auction.<br>
          Users can see all the auction status they created in "My listings."<br><br>
          <span style="font-size: larger;"><strong>Buyer:</strong></span><br>
          <strong>Bidding Process:</strong><br>
          Users can search for items they want to buy in browse section and bid on the ongoing auctions in detailed pages of items.<br>
          If the reserve price is not met by the end of the auction, the item may not be sold. (Reserve price only can be seen for sellers)<br>
          The highest bidder at the end of the auction is deemed the winner.
          The winning bidder will be sent an email of notification, and others who fail this auction will also be emailed.
</p>


          </p>
        </div>

        <!-- modal foot -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

</body>
</html>



  <!-- login form, could be placed in login.php -->
  <!-- Login modal -->
  <div class="modal fade" id="loginModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Login</h4>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="POST" action="login_result.php">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary form-control">Sign in</button>
          </form>
          <div class="text-center">or <a href="register.php">create an account</a></div>
        </div>

      </div>
    </div>
  </div> <!-- End modal -->
  </div>


 <!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Optional JavaScript to open the login modal based on URL parameter -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const showLoginModal = urlParams.get('showLoginModal');
    if (showLoginModal) {
        $('#loginModal').modal('show');
    }
});
</script>

</body>
</html>