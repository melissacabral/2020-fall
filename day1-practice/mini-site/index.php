<?php //hide notices but show everything else
error_reporting( E_ALL & ~E_NOTICE );
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>home page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>
		this is a little site
	</h1>

	<?php echo $doesnt_exist; ?>

	<?php include('includes/menu.php'); ?>

	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<?php include('includes/menu.php'); ?>

</body>
</html>