<?php 
	//upload configuration 
	//this directory must exist and be writable
	$target_directory = 'audio/';

	//who is uploading this?
	//TODO:  change this to the logged in user id ($logged_in_user['user_id'])
	$user_id = 1;

	//define valid file extensions
	$valid_extensions =  array('mp3', 'mp4', 'ogg','wav' );
	

//parse the form if the user submitted it
if( isset($_POST['did_upload']) ){

	//info about the file that they uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	$uploadedfile_name = $_FILES['uploadedfile']['name'];
	$uploadedfile_size = $_FILES['uploadedfile']['size'];
	
	//split the original name and extension for later (break the original file name at the .)
	list($title, $extension) = explode(".", $uploadedfile_name);
	
	//validate
	$valid = true;

	//is it not empty?
	if($uploadedfile_size == 0){
		$valid = false;
		$errors['size'] = 'no file data';
	}

	//is it invalid format? (this is not foolproof and can be faked. we'll check more thoroughly after it's uploaded)
	if( !in_array($extension, $valid_extensions) ){
		$valid = false;
		$errors['ext'] = "$extension is not a compatible file type.";
	}

	//if valid, save the audio
	if($valid){

		//unique string for the final file name
		$unique_string = sha1( microtime() );
		//create a name for the saved file 
		$urlsafe_filename = substr(urlencode(str_replace(' ', '_', $title)), 0, 50);
		//the final file name and location on the server (made unique just in case 2 files have same file name)
		//will look like song_title_3485672985.mp3
		$final_file =  $urlsafe_filename . '_' . $unique_string . '.' . $extension;
		//put it on the server!
		$did_save = move_uploaded_file($uploadedfile, $target_directory . $final_file);


		//TODO: if the file uploaded correctly, Add post to Database
		if( $did_save ){
			//confirm it is a real audio file before updating DB. 
			if($mime = check_file_is_audio($target_directory . $final_file)){
		
				$sql = "INSERT INTO audio
					( file, mime, user_id, title, date )
					VALUES 
					( '$final_file', '$mime', $user_id, '$title', now() )";
				$result = $db->query( $sql );
				if( ! $result ){
					echo $db->error;
				}
				if( $db->affected_rows >= 1 ){
					//success
					$audio_id = $db->insert_id;
					$feedback = "Successfully uploaded <br> <a href='single-audio.php?audio_id=$audio_id'>$title</a> ";
					$feedback_class = 'success';
					//redirect to step 2
					//header( "Location:edit-audio.php?audio_id=$audio_id" );
				}else{
					//error with SQL query
					$feedback = 'There was a problem with the Database.';
					$feedback_class = 'error';
				}
			}else{
				//error - bad MIME in actual file DELETE THE UPLOADED FILE FROM THE SERVER (unlink)!
				unlink( $target_directory . $final_file );
				$feedback = 'The file you provided does not contain audio.';
				$feedback_class = 'error';
			}

		}else{
			//error when saving the file to the folder
			$feedback = 'Your file could not be saved, try again.';
			$feedback_class = 'error';
		}//end if did_save

	}else{
		//invalid user submission
		$feedback = 'There was a problem uploading your file, fix the following:';
		$feedback_class = 'error';
	}//end if valid

}//end upload parser

//debug info
?>
