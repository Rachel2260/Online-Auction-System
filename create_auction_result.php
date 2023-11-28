<?php include_once("header.php")?>
<?php include "db_connection.php";?>

<div class="container my-5">


<?php
    include "create_auction.php";

    $auctionTitle = $_POST['auctionTitle'];
    $description = $_POST['auctionDetails'];
    $auctionCategory = $_POST["auctionCategory"];
    $end_time = $_POST["auctionEndDate"];
    $starting_price = $_POST["auctionStartPrice"];
    $reserve_price = $_POST["auctionReservePrice"];
    $user_id = $_SESSION["user_ID"];

    if ($reserve_price == ''){
        $reserve_price = $starting_price;
        $sql = "INSERT INTO auction (item_name,description,category,end_time,starting_price,reserve_price,user_ID) 
        VALUES('$auctionTitle','$description','$auctionCategory','$end_time',$starting_price,$reserve_price,$user_id)";
        if ($conn->query($sql) === TRUE) {
            echo('<div class="text-center">Auction successfully created! <a href="mylistings.php">View your new listing.</a></div>');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    elseif ($reserve_price < $starting_price){
        echo('<div class="text-center">Auction unsuccessfully created! Reserve price should not be smaller than starting price. <a href="create_auction.php">Try again.</a></div>');
    }
    else{
        $sql = "INSERT INTO auction (item_name,description,category,end_time,starting_price,reserve_price,user_ID) 
        VALUES('$auctionTitle','$description','$auctionCategory','$end_time',$starting_price,$reserve_price,$user_id)";
        if ($conn->query($sql) === TRUE) {
            echo('<div class="text-center">Auction successfully created! <a href="mylistings.php">View your new listing.</a></div>');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    
?>

</div>


<?php include_once("footer.php")?>