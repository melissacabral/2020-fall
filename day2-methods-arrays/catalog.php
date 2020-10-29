<?php 
//create an array of products
$products = array(
	//product_id => attributes
	1 		=> array(
					'title' => 'Blue Shirt',
					'price'	=> 49.99,
					'image_url' => 'https://picsum.photos/id/1001/200/200',
				),
	2 		=> array(
					'title' => 'Orange Hat',
					'price'	=> 39.99,
					'image_url' => 'https://picsum.photos/id/1025/200/200',
				),
	6 		=> array(
					'title' => 'Pink Socks',
					'price'	=> 19.49,
					'image_url' => 'https://picsum.photos/id/1023/200/200',
				),
	1000 	=> array(
					'title' => 'Gray Shorts',
					'price'	=> 39.99,
					'image_url' => 'https://picsum.photos/id/1020/200/200',
				),
);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>catalog from an array</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />
	<style type="text/css">
		.grid{
			display:flex;
			flex-wrap: wrap;
		}
		.product{
			margin:1em;
		}
	</style>
</head>
<body>

<h1>Catalog</h1>
<div class="grid">
	
	<?php foreach( $products as $product_id => $attributes ){ ?>
	<div class="product">
		<img src="<?php echo $attributes['image_url'] ?>">
		<h2><?php echo $attributes['title']; ?></h2>
		<span class="price">$<?php echo $attributes['price']; ?></span>
		<br>
		<a href="cart.php?product_id=<?php echo $product_id; ?>" class="button">Add to Cart</a>
	</div>
	<?php } //end foreach ?>	

</div><!-- end grid -->


<pre><?php print_r($products); ?></pre>

</body>
</html>