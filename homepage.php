<?php include_once("header.php")?>
<?php include "db_connection.php";?>

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
     if($address == null){
      $address = "you have not set address.";
     }
     $phone_number = $row["phone_number"];
     if($phone_number == null){
      $phone_number = "you have not set phone_number.";
     }
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

<div class="container mt-5">
  <div class="row">
    <div class = "col-5">
     <!-- the left col for personal details -->
     <h3> Your personal details:</h3>
     <strong class = "username"> username:</strong> <?php echo $username."</br>" ?>
     <strong class = "username"> email-address:</strong> <?php echo $email."</br>"?>
     <strong class = "username"> address:</strong> <?php echo $address. "</br>"?>
     <strong class = "username"> phone number:</strong> <?php echo $phone_number."</br>"?>
     
     <div row>
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
   
        <div class = "col-5">
           <!-- space reserve for picture -->
        </div>
      </div>
    </div>

