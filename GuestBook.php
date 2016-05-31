<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Guest Book</title>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
</head>
<body>

<div id="header">
	<h1>The Guest Book</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Guest Book" );
	?>
</div>

<div id="content">
	<?php

		/*
		try
		{
			$pdo = new PDO( 'mysql:host=localhost', 'root', '' );
			$pdo->setAttribute( PDO::ATTR_MODE, PDO::ERRMODE_EXCEPTION );
			
			
		}
		catch( PDOException $exception )
		{
			print "PDO Exception: " . $exceptoin->getMessage();
		}
		*/
		
		print "<h1>Under construction!</h1>\n";
	?>
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>
</html>