<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Guest Book</title>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
	<script src="GuestBook.js" type="text/javascript"></script>
</head>
<body onload="OnLoad()">

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
	<p>
		Here you can sign the guestbook or view previously made entries.
		Take this time to comment on the site.  How horrible does it look?  How badly is it designed?
		Would you use mouse pooh, cow pooh, or dinosaur pooh to describe its quality?  Or is it altogether
		so loathsome and so horrible that no amount pooh from any animal would suffice?
	</p>
	<!-- TODO: Put here a count of how many people to-date have signed the guestbook. -->
	<p><form action="" id="guestSignForm">
		<fieldset>
			<legend>Sign Guest Book</legend>
			<label>Name: </label><input type="text" value="" id="guestName"/>
			<p><label>Message: </label></p>
			<p>
				<textarea id="guestMessage" rows="10" cols="100"></textarea>
			</p>
			<!--
				This idea comes from: http://codeumbra.eu/non-obtrusive-alternatives-to-form-captchas
				It's not fool-proof, because a bot may not fill-out the field, but it's better than nothing.
				If the bot does fill-out the field, we know that the submission is automated.
			-->
			<input class="hidden-captcha" type="text" id="criticalInfo" value=""/>
			<input type="button" value="Add Entry!" onclick="AddEntry()"/>
			<div id="signResponse">
			</div>
		</fieldset>
	</form></p>
	
	<p><form>
		<fieldset>
			<legend>View Guest Book</legend>
			<p>Unless you're using Chrome, enter dates in yyyy-mm-dd format.</p>
			<label>Min-Date: </label><input type="date" id="minDate"/>
			<label>Max-Date: </label><input type="date" id="maxDate"/>
			<p><input type="button" value="View Entries!" onclick="ViewEntries()"/></p>
		</fieldset>
	</form></p>
	
	<div id="viewQueryResults">
	</div>
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>
</html>