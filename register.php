<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header('Location: index.php?page=home');
	exit;
}
require_once "config.php";
 
// check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	echo('Please complete the registration form!');
	header("Location: http://localhost:8080/ShoppingCartcopy/register.html");

}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	echo('Please complete the registration form');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 20 characters long!');
}

// check if the account with that username exists.
if ($stmt = $link->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	mysqli_stmt_bind_param($stmt, "s",$_POST['username']);
	
	mysqli_stmt_execute($stmt);
	
	// Store the result to check if the account exists in the database.
	mysqli_stmt_store_result($stmt);
	
	if (mysqli_stmt_num_rows($stmt) > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Username doesnt exists, insert new account
        if ($stmt = $link->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            // We do not want to expose passwords in our database
			//so hash the password and use password_verify when a user logs in.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
			echo 'You have successfully registered, you can now login!';
			header('Location: index.php?page=login'); //go to login page
        } else {
            // Something is wrong with the sql statement
			// check to make sure accounts table exists with all 3 fields.
            echo 'Could not prepare statement!';
        }
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement
	//check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$link->close();
?>


