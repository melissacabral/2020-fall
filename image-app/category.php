<?php 
//show 50 published posts in any category
//header contains the DB connection and functions
require('includes/header.php'); 

//which category are we showing?
//category.php?cat_id=3
$cat_id = $_GET['cat_id'];
?>

<main class="content">
	<div class="grid">
		<section class="important title">
			<h2><?php show_category_name($cat_id); ?></h2>			
		</section>

		<?php 
			//show 50 published posts in any category
		$sql = "SELECT posts.*, users.username, users.profile_pic, categories.name
		FROM categories, posts, users
		WHERE posts.category_id = categories.category_id
		AND posts.user_id = users.user_id
		AND posts.is_published = 1
		AND posts.category_id = $cat_id
		ORDER BY posts.date DESC
		LIMIT 50";
			//run this query on the DB
		$result = $db->query($sql);
			//check if it found any posts
		if( $result->num_rows >= 1 ){
				//loop it
			while( $post = $result->fetch_assoc() ){
					//print_r( $post );
				?>
				<div class="post">
					<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
						<?php show_post_image( $post['post_id'] ); ?>
					</a>

					<span class="author">
						<?php show_profile_pic($post['user_id'], 30); ?>
						<?php echo $post['username']; ?>
					</span>

					<h2><?php echo $post['title']; ?></h2>
					<span class="category"><?php echo $post['name']; ?></span>	
					<p><?php echo $post['body']; ?></p>
					<span class="date"><?php nice_date( $post['date'] ); ?></span>
					<span class="comment-count"><?php count_comments( $post['post_id'] ); ?></span>
				</div><!-- 	end .post	 -->
				<?php 
				} //end while
				//free the result
				$result->free();
			}else{
				echo '<h2>This category has no posts.</h2>';
			} //end if there are posts to show ?>

		</div>
	</main>

	<?php include('includes/sidebar.php'); ?>
	<?php include('includes/footer.php'); ?>
