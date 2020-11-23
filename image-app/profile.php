<?php 
//show 50 published posts from a specific user
//header contains the DB connection and functions
require('includes/header.php'); 

//which user profile are we showing?
//profile.php?user_id=3
$user_id = $_GET['user_id'];
?>

<main class="content">
	<div class="grid">

		<?php 
		//show up to 50 published posts from a specific user
		////OUTER LEFT join so that the user is found even if they have no posts
		$sql = "SELECT posts.*, users.username, users.profile_pic, users.bio, users.user_id
				FROM users
				LEFT JOIN posts on posts.user_id = users.user_id and posts.is_published = 1
				WHERE users.user_id = $user_id
				ORDER BY   posts.date DESC
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
				//treat the first post as a large, important post
				if( $counter == 1 ){
					?>
					<div class="important">
						<span class="author author-profile">
							<?php show_profile_pic($post['user_id'], 70); ?>
							<h4><?php echo $post['username']; ?></h4>
							<p class="bio"><?php echo $post['bio']; ?></p>
						</span>

					<?php 
					//if this user has made a post
					if( $post['post_id'] ){ ?>
						<div class="post">

						<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
							<?php show_post_image( $post['post_id'], 'large' ); ?>
						</a>				

						<h2><?php echo $post['title']; ?></h2>

						<span class="date"><?php nice_date( $post['date'] ); ?></span>
						<span class="comment-count"><?php count_comments( $post['post_id'] ); ?></span>
						</div><!-- 	end .post	 -->
					<?php 
					}else{
						echo 'this user has not posted yet';
					}//end if post exists ?>
					</div>
					<?php 
				}else{
					//treat the remaining posts as smaller posts
					?>
					<div class="post little-post item">
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
				echo '<h2>This user doesn\'t exist</h2>';
			} //end if there are posts to show ?>

	</div>
</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
