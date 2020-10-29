<?php 
//set up the whole pizza
$pizza = array(
	// key => value
	'crust' 	=> 'Crispy thin crust',
	'sauce'		=> 'Classic red',
	'cheese'	=> '3 cheese blend',
	'toppings'  => array( 'ham', 'peppers', 'pineapple' ),
);

//add one more item
$pizza['glaze'] = 'Balsamic reduction';

//change the sauce
$pizza['sauce'] = 'Pesto';

//alphabetical by key
//ksort( $pizza );

//alpha by value
asort( $pizza );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Associative Array example</title>
</head>
<body>

<h3>Nice looking list with foreach</h3>
<ul>
	<?php 
	foreach( $pizza as $key => $value ){
		echo "<li>$key: ";
		//is the value an array? 
		if( is_array($value) ){
			//show the array as comma-separated list			
			 echo '<b>' . implode( ', ', $value ) . '</b>';			
		}else{
			echo "<b>$value</b>";
		}
		echo '</li>';
	} 
	?>
	
</ul>

<pre><?php print_r( $pizza ); ?></pre>
</body>
</html>