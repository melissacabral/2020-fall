<?php 
session_start();

//if the user has a valid cookie, re-create the session
if( isset( $_COOKIE['loggedin'] ) AND isset($_COOKIE['username']) ){
	$_SESSION['loggedin'] = $_COOKIE['loggedin'];
	$_SESSION['username'] = $_COOKIE['username'];
}

//kill the page & show an error if the user is not logged in
if( ! $_SESSION['loggedin'] ){
	die('You must be logged in to view this page');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Secret Page</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
</head>
<body>
<h1>Hi, <?php echo $_SESSION['username']; ?>! Welcome to the secret page</h1>
<a href="login.php?action=logout" class="button">Log Out</a>

</body>
</html>