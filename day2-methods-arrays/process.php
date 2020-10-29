<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Passing user data through forms</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
</head>
<body>

	<h1>Results</h1>

	
<?php if( isset( $_REQUEST['fave_color'] ) AND $_REQUEST['fave_color'] != '' ){ ?>
	<p>Your favorite color is 
		<?php echo $_REQUEST['fave_color']; ?></p>
<?php } ?>


<?php if( isset( $_REQUEST['fave_animal'] ) AND $_REQUEST['fave_animal'] != '' ){ ?>
	<p>Your favorite animal  is 
		<?php echo $_REQUEST['fave_animal']; ?></p>
<?php } ?>



<section class="debug-output">
	<h4>POST array</h4>
	<pre>
	<?php print_r( $_POST ); ?>
	</pre>
	<hr>

	<h4>GET array</h4>
	<pre>
	<?php print_r( $_GET); ?>
	</pre>
	<hr>
	
	<h4>REQUEST array</h4>
	<pre>
	<?php print_r( $_REQUEST); ?>
	</pre>
</section>
</body>
</html>