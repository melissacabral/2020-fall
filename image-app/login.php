<?php 
session_start();
require('CONFIG.php');
require_once( 'includes/functions.php' );


//log out logic. query string will look like ?action=logout
if( isset($_GET['action']) AND $_GET['action'] == 'logout' ){
	//invalidate all cookies
	setcookie( 'user_id', '', time() - 9999 );
	setcookie( 'salt', '', time() - 9999 );
	//invalidate session vars and destroy session
	
	//code from https://www.php.net/manual/en/function.session-destroy.php
	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
} //end logout logic


//process the login form
if( isset($_POST['did_login']) ){
	//sanitize everything
	$username = clean_string( $_POST['username'] );
	$password = clean_string( $_POST['password'] );

	//validate
	$valid = true;
	//username between 5 and 30  (30 is varchar limit in our DB)
	if( strlen($username) < 5 OR strlen($username) > 30 ){
		$valid = false;
	}
	//password must be at least 7 characters long
	if( strlen( $password ) < 7 ){
		$valid = false;
	}
	//if valid, look them up in the DB
	if($valid){
		//get the salt, password and user id for this username
		$sql = "SELECT * 
				FROM users
				WHERE username = '$username'
				LIMIT 1";
		$result = $db->query( $sql );
		//check it twice
		if( ! $result ){
			echo $db->error;
		}
		if( $result->num_rows >= 1 ){
			//username found
			//hash and salt the provided password, so we can compare to what's in the DB
			$user = $result->fetch_assoc(); 
			$salt = $user['salt'];
			$correct_password = $user['password'];
			$provided_password = sha1( $password . $salt );
			
			//if the passwords match, log them in
			if( $provided_password == $correct_password ){
				//success - remember them for 1 week and redirect to secret page
				$expiration = time() + ( 60 * 60 * 24 * 7 );
				$user_id = $user['user_id'];
				$obscure_salt = sha1($salt);
				setcookie( 'user_id', $user_id, $expiration );
				setcookie( 'salt', $obscure_salt, $expiration );

				$_SESSION['user_id'] = $user_id;
				$_SESSION['salt'] = $obscure_salt;

				//redirect
				header('Location:index.php');
			}else{
				//error
				$feedback = 'Incorrect username and password combo. Try again.';
			}
		}else{
			//username NOT found
			$feedback = 'Username doesn\'t exist';
			$feedback_class = 'error';
		}
	}else{
		//not valid (failed length check)
		$feedback = 'Invalid Login.';
		$feedback_class = 'error';
	}//end if valid
}//end if did_login
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="container important-form">
		<h1>Log In</h1>

		
		<?php show_feedback( $feedback, $feedback_class ); ?>


		<form method="post" action="login.php">
			<label>Username</label>
			<input type="text" name="username">

			<label>Password</label>
			<input type="password" name="password">

			<input type="submit" value="Log In" >

			<input type="hidden" name="did_login" value="true">
		</form>
	</div>
</body>
</html>