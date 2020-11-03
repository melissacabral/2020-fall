<?php 
//DB Credentials:  
$host = 'localhost';
$db_name = 'phpclass_imageapp_fall2020';
$username = 'image_app_fall2020';
$password = '67s7iFehWphuaS3b';

//connect to the database
$db = new mysqli( $host, $username, $password, $db_name );

//kill the page if the DB can't connect
if( $db->connect_errno > 0 ){
	die( 'Could not connect to Database' );
}

//no close php