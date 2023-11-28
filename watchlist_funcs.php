
<?php


if (!isset($_POST['functionname']) || !isset($_POST['arguments']) ) {
  return;
}
session_start();
if(!isset($_SESSION['user_ID'])){
  return;
}
// Extract arguments from the POST variables:
$item_id = (int)$_POST['arguments'][0];
//这边要通过session get
$user_id = $_SESSION['user_ID'];
if ($_POST['functionname'] == "add_to_watchlist") {
  // TODO: Update database and return success/failure.
  include "db_connection.php";
  $sql_insert = "INSERT INTO `watch` (`user_ID`, `auction_ID`) VALUES ($user_id, '$item_id');";
  $result = mysqli_query($conn,$sql_insert);
  if($result){
    $res = "success";
  }
}

else if ($_POST['functionname'] == "remove_from_watchlist") {
  // TODO: Update database and return success/failure.
  include "db_connection.php";
  $sql = "DELETE FROM watch where user_ID= $user_id and auction_ID = '$item_id';";
  $result =  mysqli_query($conn, $sql);
  if($result){
    $res = "success";
  }else{
    $res = "fail";
  }
}

// Note: Echoing from this PHP function will return the value as a string.
// If multiple echo's in this file exist, they will concatenate together,
// so be careful. You can also return JSON objects (in string form) using
// echo json_encode($res).
echo $res;

?>