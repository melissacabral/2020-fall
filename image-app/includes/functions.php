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


//Functions to sanitize data safely for the database
function clean_string( $dirty ){
	global $db;
	$clean = mysqli_real_escape_string( $db, filter_var( $dirty, FILTER_SANITIZE_STRING ) );
	return $clean;
}
function clean_email( $dirty ){
	global $db;
	$clean = mysqli_real_escape_string( $db, filter_var( $dirty, FILTER_SANITIZE_EMAIL ) );
	return $clean;
}
function clean_int( $dirty ){
	global $db;
	$clean = mysqli_real_escape_string( $db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ) );
	return $clean;
}
function clean_boolean( $dirty ){
	if($dirty){
		return 1;
	}else{
		return 0;
	}
}



//Display feedback from a typical form 
function show_feedback( $heading, $class, $bullets ){
	if( isset($heading) ){
	?>
	<div class="feedback <?php echo $class; ?>">
		<h3><?php echo $heading; ?></h3>
		
		<?php if( !empty($bullets) ){ ?>
		<ul>
			<?php foreach( $bullets as $bullet ){
				echo "<li>$bullet</li>";
			} ?>
		</ul>
		<?php } //end if bullets not empty ?>

	</div>
	<?php
	}//end if heading exists
}


//better looking timestamps
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	//desired format: Wednesday, November 4
	echo $date->format('l, F j');
}

//Time ago function
//https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago/18602474#18602474
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//display the name of any category based on its ID
function show_category_name( $id ){
	global $db;
	$sql = "SELECT name 
			FROM categories
			WHERE category_id = $id
			LIMIT 1";
	$result = $db->query( $sql );
	if( $result->num_rows >= 1 ){
		while( $category = $result->fetch_assoc() ){
			echo $category['name'];
		}	
		$result->free();
	}
}


//no close php