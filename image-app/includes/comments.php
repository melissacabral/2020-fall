<?php //parse the comment form if it was submitted
if( isset($_POST['did_comment']) ){
	//sanitize everything
	$body = clean_string( $_POST['body'] );
	
	//validate
	$valid = true;

	//body can't be blank
	if( $body == '' ){
		$valid = false;
		$errors['body'] = 'Comment can not be blank.';
	}
	//if valid, add the comment to the database
	if( $valid ){
		$user_id = $logged_in_user['user_id'];
		$sql = "INSERT INTO comments
				( user_id, body, date, post_id, is_approved )
				VALUES
				( $user_id, '$body', now(), $post_id, 1 )";
		//run it
		$result = $db->query( $sql );
		//check it
		if( $db->affected_rows >= 1 ){
			//success
			$feedback = 'Thanks for your comment.';
			$feedback_class = 'success';
		}//end if affected rows
		else{
			//error
			$feedback = 'Something went wrong adding your comment to the database';
			$feedback_class = 'error';
		}
	}//end if valid
	else{
		$feedback = 'That\'s not a valid comment. Try again.';
		$feedback_class = 'error';
	}
	
} //end comment parse
?>

<section class="comments">
	<h2><?php count_comments( $post_id ); ?> on this post</h2>

	<?php 
	//get all the approved comments on this post, oldest first
	$sql = "SELECT users.profile_pic, users.username, comments.body, comments.date
			FROM comments, users
			WHERE comments.user_id = users.user_id
			AND comments.is_approved = 1
			AND comments.post_id = $post_id
			ORDER BY date ASC
			LIMIT 50";
	//run it
	$result = $db->query($sql);
	if( $result->num_rows >= 1 ){ 
		while( $comment = $result->fetch_assoc() ){
	?>
	<div class="one-comment">
		<div class="user">
			<img src="<?php echo $comment['profile_pic']; ?>" width="50" height="50">
			<?php echo $comment['username']; ?>
		</div>

		<p><?php echo $comment['body']; ?></p>

		<span class="date"><?php echo time_elapsed_string( $comment['date'] ); ?></span>
	</div>
	<?php 
		} //end while
		$result->free();
	} //end if comments found ?>
</section>

<?php if( $logged_in_user ){ ?>
<section class="comment-form" id="respond">
	<h2>Leave a comment:</h2>

	<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

	<form action="single.php?post_id=<?php echo $post_id; ?>#respond" method="post">
		<label>Your Comment:</label>
		<textarea name="body"></textarea>

		<input type="submit" value="Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</section>
<?php 
}else{
	echo 'Please log in to leave a comment';
}//end if logged in
?>
