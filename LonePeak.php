<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Lone Peak Hike</title>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
</head>
<body>

<div id="header">
	<h1>Lone Peak</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Lone Peak Pictures" );
	?>
</div>

<div id="content">
	<p>
	A few years ago I hiked Lone Peak in Draper Utah.  This is an outstanding
	hike with incredible scenery the entire way.  While this page
	shows the pictures I took on that hike, it also demonstrates a basic knowledge of PHP.
	(In hindsight, I would implement this page using JavaScript instead of PHP so that we don't
	fill up the browser history as we flip through the pictures.  Nevertheless, I feel this page was
	a good way to get a feel for PHP; so I'm leaving it as is.)
	</p>
	<p>
		<?php
			$figure = 0;
			if( filter_has_var( INPUT_GET, "figure" ) )
				$figure = filter_input( INPUT_GET, "figure" );
			
			if( filter_has_var( INPUT_GET, "next" ) )
				$figure++;
			else if( filter_has_var( INPUT_GET, "prev" ) )
				$figure--;
			
			// Hmmm...how can I make this sense the number of images I have in the folder?
			if( $figure < 0 )
				$figure = 18;
			else if( $figure > 18 )
				$figure = 0;
			
			$pictureFile = "LonePeakPictures/LonePeak$figure.JPG";
			
			//if( !file_exists( $pictureFile ) )
			//	$figure = 0;
			
			$caption = "???";
			
			switch( $figure )
			{
				case 0: $caption = "Here's my foot next to the summit marker."; break;
				case 1: $caption = "Near the summit looking West North West."; break;
				case 2: $caption = "Saw some climbers on the Questoin Mark Wall."; break;
				case 3: $caption = "Can't remember which way I was looking or where from."; break;
				case 4: $caption = "Looking North near the summit."; break;
				case 5: $caption = "Looking South near the summit."; break;
				case 6: $caption = "Peeking into Little Willow Cirque on the way down the North shoulder of the mountain."; break;
				case 7: $caption = "Above Little Willow Cirque."; break;
				case 8: $caption = "A view of the summit on the North shoulder approach."; break;
				case 9: $caption = "A view of the cirque along the North shoulder approach."; break;
				case 10: $caption = "I believe you can see a climber on the Question Mark Wall here."; break;
				case 11: $caption = "Ah!  The beautiful Lone Peak Cirque!!!  Bask in its glory!"; break;
				case 12: $caption = "A closer view of the summit tower."; break;
				case 13: $caption = "Another view of the cirque."; break;
				case 14: $caption = "Duplicate?"; break;
				case 15: $caption = "Fun rock slopes."; break;
				case 16: $caption = "More fun rock formations."; break;
				case 17: $caption = "Reminded me of The Wave."; break;
				case 18: $caption = "A peek at the cirque through the wavey rock."; break;
			}
			
			print <<<HERE
			<figure>
				<img src="$pictureFile">
				<figcaption>$caption</figcaption>
			</figure>
			<form action="LonePeak.php" method="get">
				<input type="hidden" name="figure" value="$figure">
				<input type="submit" name="prev" value="Previous">
				<input type="submit" name="next" value="Next">
			</form>
HERE;
		?>
	</p>
	<h2>Trip Report</h2>
	<p>
	Didn't have anyone to go with me on this hike, so I went alone to Lone Peak.  (It's probably not a good hike to
	do by yourself.)  This was also during the hottest time of the year, so I left the trail-head (not the house,
	mind you!) at 5 AM.  It was worth it too.  I did all my ascending in the cool hours of the day, the first few
	by head-lamp in the dark.  I didn't really expect to summit that day.  It was more of a recon mission so that
	the next time I came, I would know better what to expect.  It was surprising, then, to have summitted, and exciting!
	I believe I owe some of the success to being physically and mentally prepared.</p>
	<p>
	As far as mentality goes, I
	knew by experience that if I paid attention to land marks, I had a better chance of finding my way back to the trail.  You see, the Cherry Canyon trail will take you all the way to a cabin, but from there, you must make
	your own trail up through some drainages until you find the cirque.  On the way back, I started to go down the
	wrong drainage.  Fortunately, I seemed to realize that a course correction was in order, and after doing so,
	made it back to the cabin.</p>
	<p>
	Upon reaching a point where I could see the cirque for the first time, my legs were very tired, and it
	looked like I had to lose some elevation before going to the summit.  I honestly had thoughts of turning
	back at this point, but the summit looked so close that I decided to go for it.  Fortunately, I had enough
	in me, not just to summit, but to get back down to my car after doing so.
	</p>
	<p>
	Reaching the summit by the North shoulder of the mountain, I'm sure, is much easier than by
	the South shoulder.  I've not done the latter, but it's clearly easier than the former just by looking
	at it.  There's a bit of 3rd/4th-class climbing ("scrambling" doesn't seem an appropriate word here like
	it would for Salk Lake Twin Peaks) along the
	summit ridge, and there are a few exposed places where the consequences of a fall would be bad, but
	I really didn't find it too bad at all.  I tucked my pant legs into my socks to make sure I didn't trip on them
	while saddling over, climbing up, and climbing down steep, rocky sections.
	</p>
	<p>
	And then I finally reached the last leg of the journey!--Getting onto the summit block.  In my opinion,
	this is the only dicey part of the whole hike.  You can't screw it up.  It's hundreds of feet to the
	bottom of the cirque in 3 of 4 different directions, but the block is big enough that if you stand in the
	middle of it, you don't feel too exposed to the height.  Getting off the summit block was a bit nerve racking
	too.  Anyhow, after taking a picture of the summit marker, and a few views from the tippy-top, I ran off
	the summit block, counted my lucky stars, and then began the ridge descent.  I topped out at about 10:15 AM,
	I believe.
	</p>
	<p>
	Near the end of the hike I was very glad that I had rationed my water the whole way up.  Interestingly, I drank well over half of it, if not three quarters or more of it, on the last 2 hours of the hike.  This was when it was starting to get dangerously hot.  And I
	do mean dangerously!  There are a few times on other hikes when I almost didn't make it back to my care due to an onset of
	some form of heat exhaustion combined with having no calories to burn.  But not on this occation.  I had brought
	a rediculous amount of water (which turned out to be extremely reasonable, if not minimal for this hike), and
	I actually brought food on the hike too.  (I'm notorious for being idiotic about bringing proper provisions on
	hikes in the form of water and food, because, although sometimes unwise, I've gotten away with it so many times before.)
	</p>
	<p>
	Round-trip, the hike took me 10 and a half hours.  And it was brutal!  But so worth it!
	There was an amazing variety of fouliage and flowers to see.  I remember a corridor of Juniper trees
	that left the trail littered with little fuzzies.  There was a deep, dark ever-green forest with very old,
	and very large trees, and occational granit walls mixed in between, and small streems running through it.  There was a strange section of
	wavey, flowy granite.  And of course, there were the majestic cirque towers that by themselves would have
	made the entire trip worth it!  So much to see from top to bottom, I cannot emphasize enough how worth-it it is
	to do this hike.</p>
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>
</html>