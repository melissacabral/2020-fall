<?php 
session_start();
require('config.php');
require_once( 'includes/functions.php' );

//IMPORTANT: configuration for this uploader is in this parser file:
require( 'includes/audio-parse.php' ); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Audio upload example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<main class="content">	
	<a href="new-audio.php" class="button button-outline"> Upload Audio</a>
	<a href="single-audio.php" class="button button-clear"> Listen to Audio </a>
	<hr>

	<div class="narrow-container">
		<h1>Upload Audio Track</h1>
		<p>
			<b>Important:</b> configuration for this uploader is in the file <b>includes/audio-parse.php</b>.
			Edit your <i>php.ini</i> file to control the maximum upload size for your server. 
		</p>
		<p>The Upload Maximum Size is: <b><?php echo  ini_get('upload_max_filesize') ?></b></p>
		
		<?php 
		show_feedback($feedback, $feedback_class, $errors );
		?>

		<form enctype="multipart/form-data" method="post" action="new-audio.php">
			<label>Audio</label>
			<input type="file" name="uploadedfile" accept="audio/*" required>

			<input type="submit" value="Upload audio &rarr;">
			<input type="hidden" name="did_upload" value="1">
		</form>


		<hr>
		<b>Debug info: delete this after testing</b>
		<h6>$_FILES Array</h6>
		<pre><?php print_r($_FILES); ?></pre>
	</div>


</main>
	
</body>
</html>