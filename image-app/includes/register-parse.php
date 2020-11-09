<?php 
//parse the register form if it was submitted
if( isset( $_POST['did_register'] ) ){
	//clean everything
	$username 	= clean_string( $_POST['username'] );
	$password 	= clean_string( $_POST['password'] );
	$email 		= clean_email( $_POST['email'] );
	$policy 	= clean_boolean( $_POST['policy'] );

	//validate
	$valid = true;
	
	//username between 5 and 30  (30 is varchar limit in our DB)
	if( strlen( $username ) < 5  OR strlen( $username ) > 30 ){
		$valid = false;
		$errors['username'] = 'Choose a username between 5 - 30 characters long.';
	}else{
		//username must be unique - look them up in the DB
		$sql = "SELECT username 
				FROM users
				WHERE username = '$username'
				LIMIT 1";
		$result = $db->query( $sql );
		if( $result->num_rows >= 1 ){
			//username is taken
			$valid = false;
			$errors['username'] = 'Sorry, that username is already taken. Try another.';
		}
	}//end of username checks
		
	//email must be valid
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'That email address does appear to be valid.';
	}else{
		//email must be unique
		$sql = "SELECT email 
				FROM users
				WHERE email = '$email'
				LIMIT 1";
		$result = $db->query($sql);
		if( $result->num_rows >= 1 ){
			$valid = false;
			$errors['email'] = 'An account already exists with that email address. Try logging in.';
		}
	}//end email checks
		
	//password must be at least 7 characters long
	if( strlen( $password ) < 7 ){
		$valid = false;
		$errors['password'] = 'Your password is too short. Choose one that is at least 7 characters long.';
	}

	//policy must be checked
	if( ! $policy ){
		$valid = false;
		$errors['policy'] = 'You must agree to the site\'s terms of service and privacy policy';
	}
	
	//if valid, add the new user and tell them to login
	if( $valid ){
		//TODO: hash the password
		$sql = "INSERT INTO users
				( username, password, email, is_admin, join_date )
				VALUES
				( '$username', '$password', '$email', 0, now() )";
		$result = $db->query($sql);
		//check it (twice)
		if( ! $result ){
			echo $db->error;
		}
		if( $db->affected_rows >= 1 ){
			//success
			$feedback = 'Welcome!  You can now log in.';
			$feedback_class = 'success';
		}else{
			//db error
			$feedback = 'Sorry, we could not complete your registration right now. Try again later.';
			$feedback_class = 'error';
		}
	}else{
		//not valid
		$feedback = 'There were problems with your registration. Please fix the following:';
		$feedback_class = 'error';
	}//end if valid
}//end if did_register