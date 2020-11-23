<?php 
//header contains the DB connection and functions
require('includes/header.php'); 

//Search configuration: how many posts per page? edit this!
$per_page = 10;

//what did they search for?
$phrase = clean_string( $_GET['phrase'] );

//is the phrase not blank?
if( $phrase != '' ){
	//get all the published posts that contain the phrase (don't put a limit here)
	$sql = "SELECT post_id, image, title, date
			FROM posts
			WHERE ( title LIKE '%$phrase%' OR body LIKE '%$phrase%' ) 
			AND is_published = 1
			ORDER BY date DESC";
	$result = $db->query( $sql );
	//how many total posts?
	$total = $result->num_rows;
	//how many pages needed? round up the result since there's no such thing as half a page
	$max_page = ceil($total/$per_page);

	//what page are we showing?
	//?phrase=bla&page=1
	$current_page = $_GET['page'];
	//validate the page number - is it within a valid range?
	if( $current_page < 1 OR $current_page > $max_page  ){
		//default to page 1
		$current_page = 1;
	}

	// create the LIMIT statement
	$offset = ( $current_page - 1 ) * $per_page;
	//add the limit to the query
	$sql .= " LIMIT $offset, $per_page";
	//run the query again
	$result = $db->query( $sql );
}//phrase not blank
?>

<main class="content">
	<?php if( $total >= 1 ){ ?>
	<section class="title">
		<h2>Search results for <?php echo $phrase; ?></h2>
		<h3><?php echo $total; ?> posts found. 
			Showing page <?php echo $current_page ?> of <?php echo $max_page; ?></h3>
	</section>

	<section class="grid">
		<?php while( $post = $result->fetch_assoc() ){ ?>
		<div class="item">
			<a href="single.php?post_id=<?php echo $post['post_id']; ?>">

				<?php show_post_image( $post['post_id'], 'small' ); ?>
				
				<h3><?php echo $post['title']; ?></h3>
				<span class="ago"><?php time_ago($post['date']); ?></span>
			</a>
		</div>
		<?php } //end while
		$result->free();
		 ?>
	</section><!-- end .grid -->

	<div class="pagination">
		<?php 
		$prevpage = $current_page - 1;
		$nextpage = $current_page + 1;
		
		//hide previous button if we're on page 1
		if( $current_page > 1 ){ ?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prevpage; ?>" class="button">
			&laquo; Previous Page</a>
		<?php 
		}//end if not on page 1 
		if( $current_page < $max_page ){
		?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $nextpage; ?>" class="button">
			Next Page &raquo;</a>
		<?php }//end if not on the max page ?>
	</div>

	<?php 
	}else{
		echo "<h2>No posts found matching $phrase</h2>";
	} //end if posts found ?>

</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>
		