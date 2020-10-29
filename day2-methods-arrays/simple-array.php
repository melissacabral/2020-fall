<?php 
//create a list of pizza toppings
$pizza_toppings = array( 'Mushrooms', 'Artichokes', 'Caramelized Onions', 'Basil' );

//add one more topping
$pizza_toppings[] = 'Ricotta';

//randomize the list
shuffle( $pizza_toppings );

// alphabetize the values use rsort() for reverse alpha order
//sort( $pizza_toppings );

//count the toppings
$count = count($pizza_toppings);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Simple Arrays</title>
</head>
<body>
<h3>Number of toppings:</h3>
<?php echo $count; ?>

<h3>one random topping:</h3>
<?php echo $pizza_toppings[0]; ?>

<h3>Nice-looking list using a loop</h3>

<ul>
	<?php 
	foreach( $pizza_toppings as $topping ){
		echo "<li>$topping</li>";
	}	
	?>	
</ul>


<h3>ugly, but readable list:</h3>
<pre><?php print_r($pizza_toppings); ?></pre>

</body>
</html>