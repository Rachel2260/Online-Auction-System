<?php include_once("header.php")?>
<?php include "db_connection.php";?>
<?php require("utilities.php")?>

<?php
//check login status:
if(!isset($_SESSION["loggedin"])){
    echo "You have logged out";
}else{
     $user_ID = $_SESSION['user_ID'];
     $sql = "SELECT * FROM user WHERE user_ID = $user_ID";
     $result = mysqli_query($conn,$sql);
     $row = mysqli_fetch_assoc($result);
     $username = $row["username"];
     $email = $row["email"];
     $address = $row["address"];
     $phone_number = $row["phone_number"];
    }
//find personal data in the database 
?>
<style>
  .username{
  border:10px darkgray;
  background-color: darkgray;
  width:150px;
  height:60px;
  margin: 20px;
  border-radius:5px;
  text-align: center;
  line-height: 60px;
  font-size: 20px;
}

  .custom{
    margin:30px;
    text-align: center;
  }
</style>

<h2 class="ml-5"><?php echo "Welcome Home"." $username!"?> </h2>

<div class="container">

<div class="row"> 
  <div class="mx-auto pt-5"> 
  <div class="card" style="width: 45rem;">
  <div class="card-body">
    <h5 class="card-title text-info" style="font-size: 30px;">Personal information</h5>
    <h6 class="card-subtitle mb-2 ">Your personal details:</h6>
    <div class="pt-4">
    <p class="card-text text-muted" style="font-size: 20px">Username: <?php echo $username;?></p>
    <p class="card-text text-muted" style="font-size: 20px">Email: <?php echo $email;?></p>
    <p class="card-text text-muted" style="font-size: 20px">Address: <?php if($address == null){
      echo '<span style="color:lightgray;"> the address has not been set yet.</span></br>';
     }else{
      echo $address. "</br>";}?>
     <p class="card-text text-muted" style="font-size: 20px">Phone number: <?php if($phone_number == null){
      echo '<span style="color: lightgray;"> the phone number has not been set yet.</span></br>';
     }else{
      echo $phone_number."</br>";}?>
      <?php
     if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'seller') {
       echo '<p class="card-text text-muted " style="font-size: 20px"> Average rating: '.calculate_average_rating($user_ID);}
       echo calculate_average_rating($user_ID);
     ?>
     </div>

     
  </div>
         

        <div class = "col-8">
          <button type="button" class="btn btn-primary form-control custom" data-toggle="modal" data-target="#edit">edit information</button>
        </div>
        <div class="modal fade" id="edit">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
               <h4 class="modal-title">edit information</h4>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form method="POST" action="edit_personal_details.php">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="username">username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                </div>
                <div class="form-group">
                  <label for="phone_number">Phone number</label>
                  <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone number">
                </div>
                <button type="submit" class="btn btn-primary form-control">submit</button>
              </form>
            </div>

          </div>
        </div>
 
      </div>
    
    </div>
    <?php
        if (isset($_SERVER['HTTP_REFERER']) && ((strpos($_SERVER['HTTP_REFERER'], 'edit_personal_details.php') !== false)&&$_SESSION["validation"]=="success")){
        }elseif(isset($_SERVER['HTTP_REFERER']) && ((strpos($_SERVER['HTTP_REFERER'], 'edit_personal_details.php') !== false)&&$_SESSION["validation"]!="success")){
           echo '<div class="text-center">
           <p class="text-danger">Email has already exists. Enter a new one!</p>
         </div>';
        }
  ?>

