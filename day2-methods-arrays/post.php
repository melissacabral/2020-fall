<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Passing user data through forms</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
</head>
<body>

<h1>POST method example</h1>

<form method="post" action="process.php">
	<label>What's your favorite color?</label>
	<input type="text" name="fave_color">

	<label>What's your favorite animal?</label>
	<input type="text" name="fave_animal">

	<input type="submit" value="Submit Survey">
</form>


</body>
</html>