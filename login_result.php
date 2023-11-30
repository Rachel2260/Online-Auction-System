<?php 
include "db_connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Starts a User Session to track user state (login or not) across different pages 
session_start();

// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.


//  handling the user session and redirection post-login, but it lacks the actual validation of user credentials 
// Starts a User Session to track user state (login or not) across different pages 


//start a php session


//database connection
//same as connection in register, just copy to here

//retrieve user input from login form by using $POST

//Data validation and sanitization

//email still need Data validation and sanitization
//  check for POST variables exist these data or not
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.Redirecting to login...";
        //redirect to login form
        echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";
        exit;
    }

    // Password handling is not needed here as it is hashed in the database
    $password = $_POST['password'];

    // Use prepared statement for secure database query
    $query = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Email exists, fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['user_ID'] = $user['user_ID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['account_type'] = $user['role'];

            echo '<div class="text-center">You are now logged in! You will be redirected shortly.</div>';
            header("refresh:2;url=index.php");
        } else {
            echo "Invalid password.Redirecting to login...";
            //redirect to login form
            echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";
        }
    } else {
        echo "Email not registered.Redirecting to login...";
        //redirect to login form
        echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";
    }
} else {
    echo "Please enter both email and password.Redirecting to login...";
    //redirect to login form
    echo "<meta http-equiv='refresh' content='3;url=header.php?showLoginModal=true'>";
}
?>
