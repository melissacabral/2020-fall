<?php 
//header contains the DB connection and functions
require('includes/header.php'); 

//what post are we editing?
$post_id = clean_int($_GET['post_id']);
//what user is viewing the page?
$user_id = $logged_in_user['user_id'];

//form processor
require('includes/edit-post-parse.php');
?>

	<main class="content">
		<?php if( $logged_in_user ){ ?>
			<h1>Edit Post</h1>

			<?php show_post_image( $post_id ); ?>


			<?php show_feedback($feedback, $feedback_class, $errors); ?>	

			<form method="post" action="edit-post.php?post_id=<?php echo $post_id; ?>">
				<label>Title</label>
				<input type="text" name="title" value="<?php echo $title; ?>">

				<label>Body</label>
				<textarea name="body"><?php echo $body; ?></textarea>

				<label>Category</label>

				
				<?php //get all the categories in alpha order
				$sql = "SELECT *
						FROM categories
						ORDER BY name ASC";
				$result = $db->query($sql);
				if( $result->num_rows >= 1 ){
				 ?>				
				<select name="category_id">
					<option value="">Choose a category</option>

					<?php while( $cat = $result->fetch_assoc() ){ ?>
					<option value="<?php echo $cat['category_id']; ?>" 
						<?php selected( $cat['category_id'], $category_id ); ?>>
						<?php echo $cat['name']; ?>
					</option>
					<?php } //end while ?>
				</select>
				<?php } //end if categories ?>


				<label>
					<input type="checkbox" name="allow_comments" value="1" <?php checked(1, $allow_comments); ?>> 
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
		