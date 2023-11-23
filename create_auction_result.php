<?php include_once("header.php")?>

<div class="container my-5">


<?php
    include "create_auction.php";

    // Database Connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "Online_Auction_System";

    try {
        $conn = mysqli_connect($servername, $username, $password, $database);
        if (!$conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
    } catch (Exception $e) {
        echo "Connection failed. Message: " . $e->getMessage();
        exit;
    }

    
    $auctionTitle = $_POST['auctionTitle'];
    echo $auctionTitle;
    $description = $_POST['auctionDetails'];
    $auctionCategory = $_POST["auctionCategory"];
    $end_time = $_POST["auctionEndDate"];
    $starting_price = $_POST["auctionStartPrice"];
    $reserve_price = $_POST["auctionReservePrice"];
    $user_id = $_SESSION["user_ID"];
    echo $description;
    echo $end_time;
    echo $starting_price;
    echo $reserve_price;
    echo $auctionCategory;
    echo $user_id;
    
    $sql = "INSERT INTO auction (item_name,description,category,end_time,starting_price,reserve_price,user_ID) 
    VALUES('$auctionTitle','$description','$auctionCategory','$end_time',$starting_price,$reserve_price,$user_id)";
    if ($conn->query($sql) === TRUE) {
        echo "INSERT SUCCESSFULLY";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>