<?php
if( isset($_POST['did_edit']) ){
	//sanitize everything
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	
	//validate
	$valid = true;
	//title can't be blank or longer than 40 chars
	if( $title == '' OR strlen($title) > 40 ){
		$valid = false;
		$errors['title'] = 'Provide a title up to 40 characters long.';
	}
	//body can't be longer than 1000 chars
	if( strlen($body) > 1000 ){
		$valid = false;
		$errors['body'] = 'The body can\'t be longer than 1000 characters.';
	}
	//category id must be a positive, nonzero number
	if( $category_id < 1 ){
		$valid = false;
		$errors['category'] = 'Choose a category for your post.';
	}

	//if valid, UPDATE the post and make sure it belongs to this user
	if( $valid ){
		$sql = "UPDATE posts
				SET 
					title = '$title',
					body = '$body',
					category_id = $category_id,
					allow_comments = $allow_comments,
					is_published = 1
				WHERE post_id = $post_id
				AND user_id = $user_id";
		$result = $db->query($sql);
		if(! $result){
			echo $db->error;
			echo '<br>' . $sql;
		}
		if( $db->affected_rows >= 1 ){
			//success!
			$feedback = 'Successfully saved this post.';
			$feedback_class = 'success';
		}else{
			//error - nothing changed
			$feedback = 'No changes were made.';
			$feedback_class = 'info';
		}

	}else{
		//not valid
		$feedback = 'Error. Please fix the following:';
		$feedback_class = 'error';
	}//end if valid
}//end did_edit 


//pre-fill the form with the current data and make sure the logged in person is the author
$sql = "SELECT * FROM posts
		WHERE post_id = $post_id
		AND user_id = $user_id
		LIMIT 1";
$result = $db->query($sql);
if( !$result ){
	echo $db->error;
	echo '<br>' . $sql;
}
//if one row found, get the values for the form. if not, shut down the page
if( $result->num_rows >= 1 ){
	while( $post = $result->fetch_assoc() ){
		//make vars like $title, $body
		extract($post);
	}
}else{
	die('Invalid post');
}