<?php 
//count all the published posts in any category
function count_posts_in_cat( $cat_id ){
	//use the existing database variable
	global $db;
	$sql = "SELECT COUNT(*) AS total
			FROM posts
			WHERE category_id = $cat_id
			AND is_published = 1";
	//run it
	$result = $db->query($sql);
	//check it
	if( $result->num_rows >= 1  ){
		//loop it
		while( $row = $result->fetch_assoc() ){
			echo $row['total'];
		}
	}//end if 		
}

//count the number of approved comments on any post
function count_comments( $post_id ){
	global $db;
	$sql = "SELECT COUNT(*) AS total
				FROM comments
				WHERE post_id = $post_id
				AND is_approved = 1";
	//run it
	$result = $db->query($sql);
	//check it
	if( $result->num_rows >= 1 ){
		//loop it
		while( $row = $result->fetch_assoc() ){
			//display with correct grammar
			if( $row['total'] == 1 ){
					echo 'One Comment';
			}else{
				echo $row['total'] . ' Comments';
			}
		} //end while
	} //end if
}

//no close php