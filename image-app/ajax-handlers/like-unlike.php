<?php
//no doctype since this file never leaves the server
//get any needed dependencies
sleep(1);
require('../CONFIG.php');
include_once('../includes/functions.php');

//incoming data from JS - sanitize all vars!
$post_id = clean_int($_REQUEST['postId']);
$user_id = clean_int($_REQUEST['userId']);

//does this user already like this post?
$sql = "SELECT * FROM likes
		WHERE user_id = $user_id
		AND post_id = $post_id
		LIMIT 1";
$result = $db->query($sql);
if(!$result){
	echo $db->error;
}
if( $result->num_rows >= 1 ){
	//if they do, remove the like
	$sql = "DELETE FROM likes
			WHERE user_id = $user_id
			AND post_id = $post_id";
}else{
	//if not, add the like
	$sql = "INSERT INTO likes
			(user_id, post_id, date)
			VALUES
			( $user_id, $post_id, now() )";
}

//run whichever query we wound up with 
$result  = $db->query( $sql );

//update the interface
if($db->affected_rows >= 1){
	like_interface( $post_id, $user_id );
}else{
	echo 'error';
}


