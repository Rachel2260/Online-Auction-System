<?php include "db_connection.php"?>
<!-- Task -->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 
// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // data validation, then Data Sanitisation 
    //not all the column of User data is necessary, only these are necessary:

    
    //role-- need manual  check
    $role = $_POST["accountType"];
    if ($role != 'buyer' && $role != 'seller') {
        echo "Invalid Role";
    }

    //Email
    $email = $_POST["email"];
    //For filter_var($email,FILTER_VALIDATE_EMAIL)
    // it return False when the email is invalid
    //it return the emails when the email is valid
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        //the email is invalid
        echo "Invalid email address.";
    }else{
        //the email is valid
        $ $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
        // Sanitize and validate the address
    $address = filter_var($_POST["address"], FILTER_SANITIZE_SPECIAL_CHARS);

    // Sanitize and validate the phone number
    $phoneNumber = preg_replace('/\D/', '', $_POST["phoneNumber"]);
    if (strlen($phoneNumber) != 10) {
        echo "Invalid phone number format.";
        exit;
    }


    //Password
    $password = $_POST["password"];
    //define the password restriction
    //define minimum length
    $min_length=6;
    if(strlen($password)<$min_length){
        echo "Password need at least 6 characters ." ;
    }
   
    //username now input from register form not set as null as default in phpmyadmin, could revise it in personal profile
    $username = $_POST["username"];
    if (empty($username)) {
        echo "Username is required.";
    } else {
        // Sanitize the username
        $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    //Repeat Password
    $RepeatPassword = $_POST["passwordConfirmation"];
    if($password!=$RepeatPassword){
        echo "Password and Repeat Password are different.";
    }




//Data Operation-- insert new account information in the database
//fetch data from the database

//check for exsiting user


//password hashing

//insert data into database
// $stmt is an object representing a prepared statement
//$conn is an object representing a database connection
//prepare() is a method of the $conn object, Purpose: It is used to prepare an SQL statement for execution. Preparing a statement means that placeholders (usually represented by ? or named placeholders like :username) are used for user inputs, and the actual values for these placeholders are bound later.
// Prepare SELECT statement to check for existing user
$stmt = $conn->prepare("SELECT email from User where email= ?");
if (!$stmt) {
    // Error handling for statement preparation
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute statement
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user already exists
if ($result->num_rows > 0) {
    echo "User already exists. Please use a different email address.";
}elseif($password = $RepeatPassword){

} else {
    // User does not exist, so proceed with inserting the new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the INSERT statement to add a new user with the phone number and address
    $insert_stmt = $conn->prepare("INSERT INTO User (username, email, password, phone_number, address, role) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$insert_stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters for the INSERT statement and execute
    $insert_stmt->bind_param("ssssss", $username, $email, $hashed_password, $phoneNumber, $address, $role);
    if (!$insert_stmt->execute()) {
        echo "Execute failed: " . $insert_stmt->error;
    } else {
        echo "<p>Registration successful. Redirecting to login...</p>";
        echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";
    }

    // Close the INSERT statement
    $insert_stmt->close();
}


}
?>