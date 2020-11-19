<?php 
//show 50 published posts from a specific user
//header contains the DB connection and functions
require('includes/header.php'); 

//which user profile are we showing?
//profile.php?user_id=3
$user_id = $_GET['user_id'];
?>

		<main class="content">
			
			<?php 
			//show 50 published posts from a specific user
			$sql = "SELECT posts.*, users.username, users.profile_pic, users.bio, categories.name
					FROM categories, posts, users
					WHERE posts.category_id = categories.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
					AND posts.user_id = $user_id
					ORDER BY posts.date DESC
					LIMIT 50";
			//run this query on the DB
			$result = $db->query($sql);
			//check if it found any posts
			if( $result->num_rows >= 1 ){
				//make a counter to keep track of how many times the loop has run
				$counter = 1;
				//loop it
				while( $post = $result->fetch_assoc() ){
					//print_r( $post );
					if( $counter == 1 ){
			?>
			<div class="post">
				<span class="author">
					<img src="<?php echo $post['profile_pic']; ?>" width="100" height="100">
					<?php echo $post['username']; ?>
					<p class="bio"><?php echo $post['bio']; ?></p>
				</span>

				<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
					<?php show_post_image( $post['post_id'], 'large' ); ?>
				</a>				

				<h2><?php echo $post['title']; ?></h2>
			
				<span class="date"><?php nice_date( $post['date'] ); ?></span>
				<span class="comment-count"><?php count_comments( $post['post_id'] ); ?></span>
			</div><!-- 	end .post	 -->
			<?php 
					}else{
						//not on the first iteration! show smaller posts
						?>
			<div class="post little-post">
				<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
					<?php show_post_image( $post['post_id'], 'small' ); ?>
				</a>
			</div>

						<?php 
					}//end if first post
					//increase the counter
					$counter = $counter + 1;
				} //end while
				//free the result
				$result->free();
			}else{
				//empty state
				echo '<h2>This user hasn\'t posted anything yet!</h2>';
			} //end if there are posts to show ?>
		

		</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
		