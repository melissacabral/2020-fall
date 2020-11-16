<?php require('config.php');
$current_page = 'audio';
require('includes/header.php'); 

//if this page is accessed by a non-logged-in user, kill the page
if( ! $logged_in_user ){
	die('You must be logged in to see this page');
}


?>

<main class="content">	
	<?php require( 'includes/audio-parse.php' ); ?>
	<div class="important-form">
		<h1>New Audio Post</h1>

		<?php 
		show_feedback($feedback, $feedback_class, $errors );
		?>

		<form enctype="multipart/form-data" method="post" action="new-audio.php">
			<label>Audio</label>
			<input type="file" name="uploadedfile" accept="audio/*">

			<input type="submit" value="Next: post details &rarr;">
			<input type="hidden" name="did_upload" value="1">
		</form>
	</div>
</main>

<?php require('includes/sidebar.php'); ?>		
<?php require('includes/footer.php'); ?>		