<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<title>Sundial Climb</title>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
	<style type="text/css">
		img
		{
			float: left;
			border-right: 5px double white;
		}
	</style>
	<script type="text/javascript">
		function NavigateSundialPictures( delta )
		{
			var pictureNumber = document.getElementById( "pictureNumber" )
			var pictureOffset = parseInt( pictureNumber.value );
			var pictureCount = 21;		// Would be nice if I could sense this information instead of hard-coding it.
			
			if( delta > 0 )
				pictureOffset = ( pictureOffset + delta ) % pictureCount;
			else if( delta < 0 )
			{
				pictureOffset = pictureOffset + delta;
				while( pictureOffset < 0 )
					pictureOffset = pictureOffset + pictureCount;
			}
			
			var description = "???";
			switch( pictureOffset )
			{
				case 0:
				{
					description = "This is on the approach.  Mike's backpack can be seen lower-left.  The Sundial can be seen on the horizon!";
					break;
				}
				case 1:
				{
					description = "Another view on the approach.";
					break;
				}
				case 2:
				{
					description = "Here we can see Dromodary Peak, I believe.  We're almost to the first of the 3 lakes.";
					break;
				}
				case 3:
				{
					description = "There she blows!!  Our route will take us up the lit face, closer to the right.  Interestingly, the peak you see in this picture is not really a peak; it's just part of the long ridge system that leads to the real Sundial peak.  In any case, it is a worthy destination for intreped climbers.";
					break;
				}
				case 4:
				{
					description = "This is look up the first pitch at the base of the route.  The climbing wasn't terribly hard, as I recall, but the protection was slim if I recall Mike's account correctly.";
					break;
				}
				case 5:
				{
					description = "This is looking down the last pitch.  That rope goes to me!";
					break;
				}
				case 6:
				{
					description = "Here I poke my head out for the picture.  There was nothing overhanging about the route we took, as I recall.  The crux for me was described by Mike as being solved by some sort of finger-lock.  I think I pulled the move with some rope tention.  Oh-well.  I did return to this climb the next summer, I believe, with an acquaintence of mine, Jason, and we took a slightly different route that avoided the finger-lock move.  I got to lead one of the pitches (the easiest and shortest one.)  On that outing with Jason I needed rope-tention on the final dihedral section.  Oh-well.  Maybe next time?";
					break;
				}
				case 7:
				{
					description = "Here I'm working my way toward the final dihedral.";
					break;
				}
				case 8:
				{
					description = "Turn the corner!";
					break;
				}
				case 9:
				{
					description = "There's a nice big hand-hold!";
					break;
				}
				case 10:
				{
					description = "Grin with all that air below!  What a fantastic feeling!  No, I'm not on the sharp end, but it's still awesome!";
					break;
				}
				case 11:
				{
					description = "A grin upon topping-out.  I miss having a single chin.";
					break;
				}
				case 12:
				{
					description = "Mike gets comfy at the top.";
					break;
				}
				case 13:
				{
					description = "A view of all 3 lakes from the top of the route!";
					break;
				}
				case 14:
				{
					description = "A view to the East-North-East, I believe, from the top of the route.";
					break;
				}
				case 15:
				{
					description = "Are we going to rap off that dead tree?";
					break;
				}
				case 16:
				{
					description = "Can't remember why I took this.  Maybe there's some webbing here that we're using to setup the rappel?";
					break;
				}
				case 17:
				{
					description = "Mike reaches for the second rap station.  Or to figure out if that's what it is.";
					break;
				}
				case 18:
				{
					description = "Mike had me stand way over here as he pulled the rope in case there were rocks.  If any rocks fall his way, I'm sure he just karate-chops them!";
					break;
				}
				case 19:
				{
					description = "Awe, look where we are!";
					break;
				}
				case 20:
				{
					description = "On the descent I turned around and took one last shot of what we had climbed.  Good times!";
					break;
				}
			}
			
			var climbingDescription = document.getElementById( "climbingDescription" );
			climbingDescription.innerHTML = description;
			
			pictureNumber.value = pictureOffset.toString();
			
			var climbingImage = document.getElementById( "climbingImage" );
			var url = "SundialPictures/Sundial" + pictureOffset.toString() + ".jpg";
			climbingImage.src = url;
		}
		
		window.onload = function()
		{
			NavigateSundialPictures(0);
		}
	</script>
</head>
<body>

<div id="header">
	<h1>The Sundial</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Sundial Climb" );
	?>
</div>

<div id="content">
	<p>
	About 35 pounds ago (several years ago) I had an opportunity to climb the Sundial in the Lake Blanche fork
	of Big Cottenwood Canyon.  (Okay, I paid a mountain guide to take me up.)  The guy's name was
	<a href="http://www.utahmountainadventures.com/index.shtml" target="_blank">Mike Kaserman</a>,
	and he's one cool dude!  Following are pictures I and he took during the outing.
	</p>
	
	<img src="SundialPictures/Sundial0.jpg" id="climbingImage">
	
	<p id="climbingDescription">
	This is some text after the image.
	</p>
	
	<form action="">
		<input type="hidden" value="0" id="pictureNumber">
		<input type="button" value="Prev" onclick="NavigateSundialPictures(-1)">
		<input type="button" value="Next" onclick="NavigateSundialPictures(1)">
	</form>
	
	<!--<video src="SundialPictures/SundialChillinOnTop.avi" controls="controls"></video>-->
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>
</html>