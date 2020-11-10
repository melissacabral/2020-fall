<?php 
//this file uses random_bytes( 10 ) to generate random salts!
//https://www.php.net/manual/en/function.random-bytes.php

//CONFIGURATION
$password_min = 8;

error_reporting( E_ALL & ~E_NOTICE );
?>
<!DOCTYPE html>
<html>
<head>
	<title>password salter n hasher</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
	<style>body{max-width:500px; margin:2em auto;}</style>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<label>user_id</label>
	<input type="number" name="user_id">
	<label>desired password</label>
	<input type="text" name="password">
	<div class="hint">Minimum length: <?php echo $password_min; ?> characters.</div>
	<br>
	<input type="submit" value="generate">
</form>


<?php 
if(isset($_POST['password'])){
	$password = $_POST['password'];
	$user_id = $_POST['user_id'];
	
	if(  strlen( $password ) >= $password_min ){	

		$salt = bin2hex(random_bytes( 10 )); 

		$hashed = sha1( $password . $salt ); 
?>
		<div class="output">
			<h3>Your password:</h3>
			<p><?php echo $password; ?></p>
			<h3>Random Salt:</h3>
			<p><?php echo $salt; ?></p>
			<h3>Salted, Hashed password: </h3>
			<p><?php echo $hashed; ?></p>
			<hr>
			<h3>UPDATE query</h3>
			<p>UPDATE users SET salt = '<?php echo $salt; ?>', password = '<?php echo $hashed ?>' WHERE user_id = <?php echo $user_id; ?></p>
		</div>
<?php 
	}else{
		echo '<p>Oops, incorrect password length.</p>';
	}
} 
?>

</body>
</html>