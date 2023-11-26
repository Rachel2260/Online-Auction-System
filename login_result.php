<?php include "db_connection.php";?>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.


//  handling the user session and redirection post-login, but it lacks the actual validation of user credentials 
// Starts a User Session to track user state (login or not) across different pages 


//start a php session
session_start();


//database connection
//same as connection in register, just copy to here

//retrieve user input from login form by using $POST

//Data validation and sanitization

//email still need Data validation and sanitization
//  check for POST variables exist these data or not
if (isset($_POST['email']) && isset($_POST['password'])) {
   //  data sanitization for email
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   //  email validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       echo "Invalid email address.";
       exit; //  Exit if the email is invalid
   }

//Don't need to check password as it already hashed in database 
$password = $_POST['password'];



//fetch the data from database

//method 1 to fetch (not secure enough) data
// $query = "SELECT * FROM users WHERE email='$email'";
// $result = $conn->query($query);

//method 2 used prepared statement to fetch (more secure) data
// Check if the email exists in the database
$query = $conn->prepare("SELECT * FROM User WHERE email = ?"); 
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();


//Verify the data retreive from login form and fetch from the database
//first if statement is F,then can't find such email--not registed
if ($result->num_rows > 0) {
   // fetch_assoc() returns an associative array of strings representing the fetched row in the result set
   $user = $result->fetch_assoc();
   if (password_verify($password, $user['password'])) {
       // Password is correct, set session variables(retain across multiple pages)
       $_SESSION['loggedin'] = true;
       $_SESSION['user_ID'] = $user['user_ID'];
       $_SESSION['username']=$user['username'];
       $_SESSION['account_type'] = $user['role'];

       //Displays a Login Confirmation Message
       echo ('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');
       // Redirect to index(main page) after 5 seconds
       header("refresh:5;url=index.php");
   } else {
       // Password is not correct
       echo "Invalid password.";
   }
} else {
   // Email not found
   echo "Email not registered.";
}
} else {
   // #Changed: Added a message for missing email or password in POST request
   echo "Please enter email and password.";
}

?>

<!-- Form Data Handling (Extracting $_POST Variables):

// Security and Functionality: User credentials (like username and password) are typically sent from a login form via the $_POST array in PHP. It's essential to retrieve these values to process the login request.
// Data Validation and Sanitization: Checking if the variables are set and sanitizing them prevents security issues like SQL injection and ensures that the input is in an expected format.
// Validate Credentials:

// User Authentication: This is the core of the login process. You need to verify whether the username and password provided match what's stored in your system (usually a database). This step confirms the user's identity.
// Preventing Unauthorized Access: Without proper validation, anyone could access user accounts, leading to serious security breaches.
// Error Handling and Feedback:

// User Experience: Users need to know if they've successfully logged in or if there was an error (like entering the wrong password). Clear feedback helps guide them on what to do next.
// Security: Proper error handling also means avoiding revealing sensitive information that could be exploited by attackers (e.g., specifying whether a username or password is incorrect can be used for malicious purposes).
// Conditional Redirection:

// User Flow: You should only redirect users to another page (like a dashboard) if they successfully log in. If the login fails, they should stay on the login page or be given alternative options.
// Security: Unconditional redirection could mislead users into thinking they have successfully logged in when they haven't, or it could expose pages meant only for authenticated users. -->