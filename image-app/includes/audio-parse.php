<?php 
	//upload configuration 
	//this directory must exist and be writable
	$target_directory = 'audio/';

	//define valid file extensions
	$valid_mimes =  array('audio/mpeg', 'audio/mp4', 'audio/ogg','audio/webm','audio/wav' );
	
	//who is uploading this?
	$user_id = $logged_in_user['user_id'];

//if the user submitted the form
if( isset($_POST['did_upload']) ){

	//info about the file that they uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	$uploadedfile_name = $_FILES['uploadedfile']['name'];
	$uploadedfile_size = $_FILES['uploadedfile']['size'];
	$uploadedfile_mime = $_FILES['uploadedfile']['type'];
	
	//split the original name and extension for later (break the original file name at the .)
	list($filename, $extension) = explode(".", $uploadedfile_name);
	//convert spaces to _ in the filename
	$url_filename = str_replace(' ', '_', $filename);

	//validate
	$valid = true;

	//is it not empty?
	if($uploadedfile_size == 0){
		$valid = false;
		$errors['size'] = 'no file data';
	}

	//is it invalid format?
	//TODO: check this better
	if( !in_array($uploadedfile_mime, $valid_mimes) ){
		$valid = false;
		$errors['format'] = "Your file has the wrong file type. $uploadedfile_mime";
	}

	//if valid, save the audio
	if($valid){

		//unique string for the final file name
		$unique_string = sha1( microtime() );

		//the final file name (made unique just in case 2 files have same file name)
		$final_name =  $url_filename . '_' . $unique_string . '.' . $extension;
		//put it on the server!
		$did_save = move_uploaded_file($uploadedfile, $target_directory . $final_name);


		//TODO: if the file uploaded correctly, Add post to Database
		if( $did_save ){
		
			$sql = "INSERT INTO audio
				( file, mime, user_id, title, date )
				VALUES 
				( '$final_name', '$uploadedfile_mime', $user_id, '$filename', now() )";
			$result = $db->query( $sql );
			if( ! $result ){
				echo $db->error;
			}
			if( $db->affected_rows >= 1 ){
				//success
				$feedback = "Successfully uploaded <br> $final_name";
				$audio_id = $db->insert_id;
				//redirect to step 2
				header( "Location:edit-audio.php?audio_id=$audio_id" );
			}else{
				//error
				$feedback = 'There was a problem with the Database.';
			}

		}else{
			$feedback = 'Your file could not be saved, try again.';
		}//end if did_save

	}//end if valid
	else{
		$feedback = 'There was a problem uploading your image, fix the following:';
	}

}//end upload parser

//debug info
?>
<pre><?php print_r($_FILES); ?></pre>