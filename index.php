<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<title>Spencer's Website!</title>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
</head>
<body>

<div id="header">
	<h1>Spencer's Website!</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Home" );
	?>
</div>

<div id="content">
	<h2>Welcome!</h2>
	<p>
	The purpose of this site is to demonstrate to prospective employers a basic knowledge of
	various web-development technologies including HTML/CSS, JavaScript, AJAX, PHP and MySQL.
	These initial examples are simple, but I hope to add more and more sophisticated pages as time goes by.
	</p>
	<p>
	I keep an up-to-date copy of my resume <a href="https://sites.google.com/site/spencertparkinresume/">here</a>.
	</p>
	<p>
	The ugly guy in the photo below is me.
	</p>
	<img src="MeAndBop.jpg">
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>
</html>