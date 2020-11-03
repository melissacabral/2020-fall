<?php
error_reporting( E_ALL & ~E_NOTICE );

//custom function to make the <select> dropdown "stick"
function selected( $user_choice, $expected ){
     if( $user_choice == $expected ){
          echo 'selected';
     }
}

//process the form if they submitted it
if (isset( $_POST['did_submit'] )) {
//sanitize every field
     $name = filter_var( $_POST['name'], FILTER_SANITIZE_STRING );
     $email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
     $phone = filter_var( $_POST['phone'], FILTER_SANITIZE_NUMBER_INT );
     $reason = filter_var( $_POST['reason'], FILTER_SANITIZE_STRING );
     $message = filter_var( $_POST['message'], FILTER_SANITIZE_STRING );
     $did_submit = filter_var( $_POST['did_submit'], FILTER_SANITIZE_NUMBER_INT );

//validate anything that needs it
     $valid = true;

//name min length:2, max length 50
     if( strlen( $name ) < 2 OR strlen( $name ) > 50  ){
          $valid = false;
          $errors['name'] = 'Please fill in a name between 2 - 50 characters long.';
     }

//invalid email check
     if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
          $valid = false; 
          $errors['email'] = 'Please fill in a valid email, like janedoe@mail.com.'; 
     }

//reason given is not on the list of possible reasons
     $allowed_reasons = array( 'support', 'bug report', 'hi' );
     if( ! in_array( $reason , $allowed_reasons ) ){
          $valid = false;
          $errors['reason'] = 'Please choose a reason from the list provided.';
     }

//message wrong length (1-2000 chars)
     if( strlen($message) < 1 OR strlen($message) > 2000 ){
          $valid = false;
          $errors['message'] = "Please fill in a message between 1 - 2000 characters long.";
     }

//if everything is valid, send mail (if not, show them an error)
     if( $valid ){
          //send mail
          $to = "mcabral@platt.edu, $email";
          $subject = "$reason: $name just sent you a message";
          //use \n for a new line
          $body = "Sender's name: $name \n";
          $body .= "Phone Number: $phone \n";
          $body .= "Email Address: $email \n\n";
          $body .= "Sender's Message: $message";

          //use \r\n to divide headers
          $headers = "From: admin@melissacabral.com \r\n";
          $headers .= "Reply-to: $email";

          $sent_mail = mail( $to, $subject, $body, $headers );
          
          //create feedback
          if($sent_mail){
               $feedback = 'Thank you for contacting me, I\'ll get back to you shortly.';
               $feedback_class = 'success';
          }else{
               $feedback = 'Sorry, something went wrong on our end. Please contact customer service or try again later';
               $feedback_class = 'error';
          }
     }else{
          $feedback = 'There was a problem with your submission. Please fix the following:';
          $feedback_class = 'error';
     }
}//end of form processor
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Contact Us</title>
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">

     <style type="text/css">
          .feedback{
               padding:1em;
               margin:1em 0;
               border:solid 1px gray;
          }
          .error{
               background-color: #FFB5B5;
               border-color:#FF3636;
          }
          .success{
               background-color: #B3FFBC;
               border-color:#45E074;
          }
     </style>
</head>
<body>
     <div class="contact-form">
          <h1>Contact Us</h1>

          <?php if( isset( $feedback ) ){ ?>
               <div class="feedback <?php echo $feedback_class; ?>">
                    <h3><?php echo $feedback; ?></h3> 

                    <?php if( ! empty( $errors ) ){ ?>
                         <ul>                        
                              <?php foreach( $errors as $value ){
                                   echo "<li>$value</li>";
                              } ?>
                         </ul> 
                    <?php } ?>

               </div>
          <?php } //end if feedback ?>


          <form action="contact.php" method="post">
               <label>Your Name</label>
               <input type="text" name="name" value="<?php echo $name; ?>">


               <label>Email Address</label>
               <input type="email" name="email" value="<?php echo $email; ?>">


               <label>Phone Number</label>
               <input type="tel" name="phone" value="<?php echo $phone; ?>">


               <label>How can we help you?</label>
               <select name="reason">
                    <option value="support" <?php selected( $reason, 'support' ); ?>>I need customer support.</option>
                    <option value="bug report" <?php selected( $reason, 'bug report' ); ?>>I'm reporting a bug.</option>
                    <option value="hi" <?php selected( $reason, 'hi' ); ?>>I just wanted to say Hi!</option>
               </select>


               <label>Message</label>
               <textarea name="message"><?php echo $message; ?></textarea>


               <input type="submit" value="Send Message">
               <input type="hidden" name="did_submit" value="1">
          </form>
     </div>

     <h3>$_POST array</h3>
     <pre><?php print_r($_POST); ?></pre>

     <h3>Testing the body of the email:</h3>
     <pre><?php echo $body; ?></pre>
</body>
</html>