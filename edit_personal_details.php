<?php include_once("header.php")?>
<?php include "db_connection.php";?>

<!-- get the parameter from form-->
<?php
if(!isset($_SESSION["user_ID"])){
    echo"sorry you have logged out.";
}else{
    $user_ID = $_SESSION["user_ID"];
    $sql = "SELECT * FROM user WHERE user_ID = $user_ID";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
    $email = $row["email"];
    $address = $row["address"];
    $phone_number = $row["phone_number"];
}


if(isset($_POST["email"]) && $_POST["email"]!=""){
    $email = $_POST["email"];
}
echo $email;
if(isset($_POST["username"]) && $_POST["username"]!=""){
    $username = $_POST["username"];    
}
echo $username;
if(isset($_POST["address"]) && $_POST["address"]!=""){
    $address = $_POST["address"];
}
echo $address;
if(isset($_POST["phone_number"]) && $_POST["phone_number"]!=""){
    $phone_number = $_POST["phone_number"];
}
echo $phone_number;

$sql = "UPDATE user SET username = '$username', email = '$email', address = '$address', phone_number = '$phone_number'
WHERE user_ID = $user_ID;";

$result = mysqli_query($conn,$sql);
if($result){
    $url = 'homepage.php';
    echo '<script>window.location.href="'.$url.'";</script>';
}

?>
