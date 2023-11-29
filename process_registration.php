<?php include "db_connection"?>
<!-- Task
     -->

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
    $username = filter_var($username, FILTER_SANITIZE_STRING);
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
} else {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare INSERT statement to add new user
    $insert_stmt = $conn->prepare("INSERT INTO User(username, email, password, role) VALUES (?, ?, ?, ?)");
    if (!$insert_stmt) {
        // Error handling for INSERT statement preparation
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters for INSERT statement and execute
    $insert_stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
    if (!$insert_stmt->execute()) {
        // Detailed error message if execution fails
        echo "Execute failed: " . $insert_stmt->error;
    } else {
        //print sucess message
        echo "<p>Registration successful. Redirecting to login...</p>";
        //use meta tag to redirect to login page (here login.php can be replaced)
        // Redirect to home.php and indicate that the login modal should be opened
        echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";

    // Close the INSERT statement
    $insert_stmt->close();
 }

// Close the SELECT statement
$stmt->close();
}

// Close the Database Connection
mysqli_close($conn);

}
?>