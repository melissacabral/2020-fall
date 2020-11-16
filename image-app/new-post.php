<?php 
//header contains the DB connection and functions
require('includes/header.php'); 
//form processor
require('includes/new-post-parse.php');
?>

	<main class="content">
		<?php if( $logged_in_user ){ ?>

		<?php show_feedback($feedback, '', $errors); ?>	

		<div class="important-form">
			<h1>New Post</h1>
			<form method="post" action="new-post.php" enctype="multipart/form-data">
				<label>Image File:  (jpg, gif, png allowed)</label>
				<input type="file" name="uploadedfile" accept="image/*" required>

				<input type="submit" value="Next: Post Details &rarr;">
				<input type="hidden" name="did_upload" value="1">
			</form>
		</div>

		<h2>Delete when finished testing the $_FILES array:</h2>
		<pre><?php print_r($_FILES); ?></pre>
		
		<?php }else{
			echo '<h1>You must be logged in to create a post.</h1>';
		} ?>
	</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
		