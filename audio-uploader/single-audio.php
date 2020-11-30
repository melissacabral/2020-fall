<?php 
session_start();
require('config.php');
require_once( 'includes/functions.php' );

//get the id from the URL, sanitize it since we'll use it in a DB query
$audio_id = clean_int($_GET['audio_id']);
if($audio_id == ''){
	$audio_id = 0;
}

//folder that audio files are stored in
$target_directory = 'audio/';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Audio playback example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<main class="content">	
		<a href="new-audio.php" class="button button-clear"> Upload Audio</a>
		<a href="single-audio.php" class="button button-outline"> Listen to Audio </a>	
		<hr>
		<div class="container">

		<div class="row">
			<div class="column column-60">					
				<h1>Play Audio Track</h1>
				<?php 
				//get the selected track from the DB
				$sql = "SELECT * 
				FROM audio  
				WHERE audio_id = $audio_id 
				LIMIT 1";
				$result = $db->query($sql);
				if(! $result){
					echo $db->error;
				}
				if($result->num_rows >= 1){
					$audio = $result->fetch_assoc();
					$filepath = $target_directory . $audio['file'] ;
				 ?>

					<h2><?php echo $audio['title']; ?></h2>
					<audio controls>
						<source src="<?php echo $filepath; ?>" type="<?php echo $audio['mime']; ?>" preload="auto" >
					</audio>
					<hr>
					<h4>All data for this track:</h4>
					<pre><?php print_r($audio); ?></pre>
					
				<?php 
				}else{
						echo 'No track selected.';
				} 
				?>
			</div><!-- end .column -->


			<div class="column column-40">

				<?php //show a list of all audio for navigation
				$sql = "SELECT * FROM audio ORDER BY date DESC LIMIT 30";
				$result = $db->query( $sql );
				if($result->num_rows >=1){
					?>
					<h3>Choose an audio track</h3>
					<ul>
						<?php while($audio = $result->fetch_assoc()){ ?>
							<li>
								<a href='single-audio.php?audio_id=<?php echo $audio['audio_id']; ?>'>
								<?php echo $audio['title']; ?>									
								</a>
							</li>
						<?php }
						$result->free(); 
						?>
					</ul>
				<?php } ?>
				
			</div><!-- end .column -->
		</div>	<!-- end .row -->		
				


	

</div><!-- end container -->
</main>
</body>
</html>	