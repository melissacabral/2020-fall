<?php 
//header contains the DB connection and functions
require('includes/header.php'); 
//which post was clicked?
//TODO: sanitize and validate this
$post_id = $_GET['post_id'];
?>

		<main class="content">
			
			<?php 
			//get the published post that was clicked as well as their author names, and category names
			$sql = "SELECT posts.*, users.username, users.profile_pic, categories.name
					FROM categories, posts, users
					WHERE posts.category_id = categories.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
					AND posts.post_id = $post_id
					LIMIT 1";
			//run this query on the DB
			$result = $db->query($sql);
			//check if it found any posts
			if( $result->num_rows >= 1 ){
				//loop it
				while( $post = $result->fetch_assoc() ){
					//print_r( $post );
			?>
			<div class="post">
				
				<?php show_post_image( $post['post_id'], 'large' ); ?>

				<?php if( $post['user_id'] == $logged_in_user['user_id']){ ?>
				<a href="edit-post.php?post_id=<?php echo $post['post_id']; ?>" class="button button-outline button-small float-right">Edit</a>
				<?php } ?>
				

					<span class="author">
					<a href="profile.php?user_id=<?php echo $post['user_id']; ?>">
						<img src="<?php echo $post['profile_pic']; ?>" width="50" height="50">
						<?php echo $post['username']; ?>
					</a>
				</span>

				<h2><?php echo $post['title']; ?></h2>
				
				<span class="category">
					<a href="category.php?cat_id=<?php echo $post['category_id']; ?>">
					<?php echo $post['name']; ?>
					</a>	
				</span>	
				<p><?php echo $post['body']; ?></p>
				<span class="date"><?php nice_date( $post['date'] ); ?></span>
				<span class="comment-count"><?php count_comments( $post['post_id'] ); ?></span>
			</div><!-- 	end .post	 -->
			<?php 				

				} //end while posts
				//free the result
				$result->free();

				//load the comments
				include('includes/comments.php');
			
			}else{
				echo '<h2>No posts to show</h2>';
			} //end if there are posts to show ?>
		

		</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
		