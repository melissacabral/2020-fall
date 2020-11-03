<?php 
//load the DB connection and configuration
require( 'CONFIG.php' ); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Image App</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="site">
		<header class="header">
			<h1><a href="index.php">Image App</a></h1>
		</header>
		<main class="content">
			
			<?php 
			//get the most recent 20 published posts
			$sql = "SELECT image, title, body, date
					FROM posts
					WHERE is_published = 1
					ORDER BY date DESC
					LIMIT 20";
			//run this query on the DB
			$result = $db->query($sql);
			//check if it found any posts
			if( $result->num_rows >= 1 ){
				//loop it
				while( $post = $result->fetch_assoc() ){
					//print_r( $post );
			?>
			<div class="post">
				<a href="#">
					<img src="<?php echo $post['image']; ?>" alt="">
				</a>
				<h2><?php echo $post['title']; ?></h2>
				<p><?php echo $post['body']; ?></p>
				<span class="date"><?php echo $post['date']; ?></span>
			</div><!-- 	end .post	 -->
			<?php 
				} //end while
				//free the result
				$result->free();
			}else{
				echo '<h2>No posts to show</h2>';
			} //end if there are posts to show ?>
		

		</main>

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
					<li><?php echo $cat['name']; ?> (20)</li>
					<?php } //end while
					//free it
					$result->free(); ?>
					
				</ul>
			</section>
			<?php } //end if ?>

			<?php //get up to 5 most recent approved comments  
			$sql = "SELECT body 
					FROM comments
					WHERE is_approved = 1
					ORDER BY date DESC
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
					<li><?php echo $comment['body']; ?></li>
					<?php } //end while
					$result->free(); ?>
				</ul>
			</section>
			<?php }  //end if comments?>
		</aside>
		<footer class="footer">
			&copy; 2020 Image App
		</footer>
	</div> <!-- end div.site -->
</body>
</html>