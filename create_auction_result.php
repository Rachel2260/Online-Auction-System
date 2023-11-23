<?php include_once("header.php")?>

<div class="container my-5">


<?php
    include "create_auction.php";
    $link = mysqli_connect('localhost','root','','online_auction_system_1');

    if (!$link){
        exit('connect failed');
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
        $sql = "INSERT INTO auction (item_name,description,category,end_time,starting_price,reserve_price,user_id) 
        VALUES('$auctionTitle','$description','$auctionCategory','$end_time',$starting_price,$reserve_price,$user_id)";
        if ($link->query($sql) === TRUE) {
            echo "INSERT SUCCESSFULLY";
        } else {
            echo 
        "Error: " . $sql . "<br>" . $link->error;
        }
echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>