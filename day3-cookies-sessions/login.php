<?php 
session_start();

//log out logic. query string will look like ?action=logout
if( isset($_GET['action']) AND $_GET['action'] == 'logout' ){
	//invalidate all cookies
	setcookie( 'loggedin', 0, time() - 9999 );
	setcookie( 'username', '', time() - 9999 );
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

if( isset($_POST['did_login']) ){
	//process the login form
	//temporary correct username and pass - remove this when we learn about DBs
	$correct_username = 'Melissa';
	$correct_password = 'phprules';
	//if the credentials are correct, send the user to the secret page
	if( $_POST['username'] == $correct_username AND $_POST['password'] == $correct_password ){
		//success - remember them for 1 week and redirect to secret page
		$expiration = time() + ( 60 * 60 * 24 * 7 );
		setcookie( 'loggedin', 1, $expiration );
		setcookie( 'username', $_POST['username'], $expiration );
		//create session vars to match the cookies
		$_SESSION['loggedin'] = 1;
		$_SESSION['username'] = $_POST['username'];
		//redirect
		header('Location:secret.php');
	}else{
		//error
		$feedback = 'Incorrect username and password combo. Try again.';
	}
}//end if did_login
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
	<style type="text/css">
		.feedback{
			background-color: #FBBFBF;
			padding: 1em;
		}
	</style>
</head>
<body>
	<h1>Log In</h1>

	<?php if( isset( $feedback ) ){ ?>
		<div class="feedback">
		<?php echo $feedback; ?>
		</div>
	<?php } //end if feedback ?>


	<form method="post" action="login.php">
		<label>Username</label>
		<input type="text" name="username">

		<label>Password</label>
		<input type="password" name="password">

		<input type="submit" value="Log In" >

		<input type="hidden" name="did_login" value="true">
	</form>

<h4>$_POST</h4>
<pre><?php print_r( $_POST ); ?></pre>	

</body>
</html>