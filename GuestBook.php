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
	<p>
		Note that some effort was put into detering spam bots, but I have yet to add some sort of
		captcha to this page.  Google provides a good solution, but I'm still trying to figure out how to use it.
		In the mean time, if you find any security holes in this page, please let me know about it so that I
		can try to fill them.  Of course, there's nothing important about this page; it's sole purpose is to
		give me some experience with a page having a MySQL/PDO backend.
		And, of course, don't input any sensative information into this page.  I'm not yet using SSL,
		and everyone can view anyone else's posts anyway.
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
			<input type="button" value="Add Entry!" onclick="AddEntry()" id="addEntryButton"/>
			<img src="16_cycle_one_24.gif" id="addLoadingIcon" hidden>
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
			<p><input type="button" value="View Entries!" onclick="ViewEntries()" id="viewEntriesButton"/><img src="16_cycle_one_24.gif" id="viewLoadingIcon" hidden></p>
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