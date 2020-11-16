<?php 
//header contains the DB connection and functions
require('includes/header.php'); 
//form processor
require('includes/edit-post-parse.php');
?>

	<main class="content">
		<?php if( $logged_in_user ){ ?>
			<h1>Edit Post</h1>
			<img src="IMAGE">
				
			<?php show_feedback($feedback, '', $errors); ?>	

			<form method="post" action="edit-post.php">
				<label>Title</label>
				<input type="text" name="title">

				<label>Body</label>
				<textarea name="body"></textarea>

				<label>Category</label>

				<select name="category_id">
					<option value="CAT_ID">NAME</option>
				</select>

				<label>
					<input type="checkbox" name="allow_comments" value="1">
					Allow comments on this post
				</label>

				<input type="submit" value="Save Post">
				<input type="hidden" name="did_edit" value="1">
			</form>



	
		<?php }else{
			echo '<h1>You must be logged in to create a post.</h1>';
		} ?>
	</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
		