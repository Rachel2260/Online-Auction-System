<?php include_once("header.php")?>
<?php include "db_connection.php";?>

<!-- get the parameter from form-->
<?php
if(!isset($_SESSION["user_ID"])){
    echo"sorry you have logged out.";
}else{
    $user_ID = $_SESSION["user_ID"];
    $item_ID = (int)$_POST["item_ID"];
    if(isset($_POST['rating'])){
        $mark = (int)$_POST["rating"];
        echo "$mark";
        $sql = "INSERT INTO `marking` (`auction_ID`, `user_ID`, `mark`) VALUES ('$item_ID', '$user_ID', '$mark');";
        $result = mysqli_query($conn,$sql);
        if($result){
            $url = 'listing.php?item_id=' . $item_ID;
            echo '<script>window.location.href="'.$url.'";</script>';
    exit;
         }else{echo "error";}
    }else{
        echo "not finished rating as input nothing.";
    }
    
}
