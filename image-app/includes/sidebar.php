<aside class="sidebar">
		<?php 
		//get up to 5 recently joined users
		$sql = "SELECT username, profile_pic
				FROM users
				ORDER BY join_date DESC
				LIMIT 5";
		//run it
		$result = $db->query($sql);	
		//check it for at least 1 row (user)
		if( $result->num_rows >= 1 ){			 
		?>			
		<section class="users">
			<h2>Newest Users:</h2>
			<ul>
				<?php while( $user = $result->fetch_assoc() ){ ?>
				<li class="user">
					<img src="<?php echo $user['profile_pic'] ?>" width="50" height="50">
					<?php echo $user['username']; ?>
				</li>
				<?php } //end while
				//free it
				$result->free(); ?>
				
			</ul>
		</section>
		<?php } //end if users ?>

		
		<?php //get up to 10 categories in alphabetical order by name 
		$sql = "SELECT * 
				FROM categories
				ORDER BY name ASC
				LIMIT 10";
		//run it
		$result = $db->query($sql);
		//check it
		if( $result->num_rows >= 1 ){
		 ?>
		<section class="categories">
			<h2>Image categories:</h2>
			<ul>
				<?php 
				//loop it
				while( $cat = $result->fetch_assoc() ){ ?>
				<li><?php echo $cat['name']; ?> (<?php 	count_posts_in_cat( $cat['category_id'] ); ?>)</li>
				<?php } //end while
				//free it
				$result->free(); ?>
				
			</ul>
		</section>
		<?php } //end if ?>

		<?php //get up to 5 most recent approved comments, as well as the username that wrote the comment and the title of the post that the comment is about
		$sql = "SELECT comments.body, users.username, posts.title 
				FROM comments, users, posts
				WHERE comments.is_approved = 1
				AND comments.user_id = users.user_id
				AND comments.post_id = posts.post_id
				ORDER BY comments.date DESC
				LIMIT 5";
		//run it
		$result = $db->query($sql);
		//check it
		if( $result->num_rows >= 1 ){
		 ?>
		<section class="comments">
			<h2>Recent Comments:</h2>
			<ul>
				<?php while( $comment = $result->fetch_assoc() ){ ?>
				<li>
					<?php echo $comment['username']; ?> said: 
					<b>&ldquo;<?php echo $comment['body']; ?>&rdquo;</b>
					about <?php echo $comment['title']; ?>
				</li>
				<?php } //end while
				$result->free(); ?>
			</ul>
		</section>
		<?php }  //end if comments?>
	</aside>