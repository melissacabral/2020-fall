<?php 
session_start();
//load the DB connection and configuration
require( 'CONFIG.php' );
require_once( 'includes/functions.php' );

//is the person viewing the page logged in?
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Image App</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="site">
		<header class="header">
			<h1><a href="index.php">Image App</a></h1>

			<nav class="main-navigation">
				<form method="get" action="search.php" class="searchform">
					<label class="screen-reader-text">Search:</label>
					<input type="search" name="phrase" required>
					<input type="hidden" name="page" value="1">
					<input type="submit" value="Search">
				</form>

				<ul class="menu">
					<?php if( $logged_in_user ){ 
						//logged in navigation ?>
					<li><a href="new-post.php">New Post</a></li>
					<li><a href="#"><?php echo $logged_in_user['username']; ?>'s Profile</a></li>
					<li><a href="login.php?action=logout">Log Out</a></li>
					
					<?php }else{ 
						//not logged in navigation ?>

					<li><a href="register.php">Sign Up</a></li>
					<li><a href="login.php">Log In</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>