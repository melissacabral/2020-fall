<footer class="footer">
			&copy; 2020 Image App
		</footer>
	</div> <!-- end div.site -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>	

<script>
	//simple example first
	$('.likes').on( 'click', '.heart-button' , function(){
		//which heart did they click
		var postId = $(this).data('postid');
		//who clicked it?
		var userId = <?php echo $logged_in_user['user_id']; ?>;
		console.log(postId, userId);

		//grab the parent container of the heart they clicked
		var likes_container = $(this).parents('.likes');

		$.ajax({
			method 	: 'GET',
			url 	: 'ajax-handlers/like-unlike.php',
			data	: { 'userId' : userId, 'postId': postId },
			success : function( response ){
				//update the likes interface
				likes_container.html( response );
			},
			error 	: function(){
				console.log('ajax error');
			}
		});

	} );
</script>
</body>
</html>