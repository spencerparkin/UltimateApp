<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Guest Book</title>
</head>
<body>

<h1>The Guest Book</h1>

<p>
<?php
	try
	{
		$pdo = new PDO( 'mysql:host=localhost', 'root', '' );
		$pdo->setAttribute( PDO::ATTR_MODE, PDO::ERRMODE_EXCEPTION );
		
		
	}
	catch( PDOException $exception )
	{
		print "PDO Exception: " . $exceptoin->getMessage();
	}
?>
</p>

</body>
</html>