<?php require('config.php');
require('includes/header.php'); 

//if this page is accessed by a non-logged-in user, kill the page
if( ! $logged_in_user ){
	die('You must be logged in to see this page');
} 
//get the id from the URL
$audio_id = clean_int($_GET['audio_id']);
//folder that audio files are stored in
$target_directory = 'audio/';
//who is accessing this?
$user_id = $logged_in_user['user_id'];


?>

<main class="content">	
	<div class="important-form">
		<?php 
		$sql = "SELECT * 
				FROM audio  
				WHERE audio_id = $audio_id 
				AND user_id = $user_id
				LIMIT 1";
		$result = $db->query($sql);
		if(! $result){
			echo $db->error;
		}
		if($result->num_rows >= 1){
			$audio = $result->fetch_assoc();
			$path = $target_directory . $audio['file'] ;

			?>
			<h1>Your track:</h1>
			<h2><?php echo $audio['title']; ?></h2>
			<audio controls>
				<source src="<?php echo $path; ?>" type="<?php echo $audio['mime']; ?>">

					<?php 

				}else{
					echo 'That audio does not exist';
				} ?>


			</audio>
		</div>
	</main>

	<?php require('includes/sidebar.php'); ?>		
	<?php require('includes/footer.php'); ?>		