<?php

	// TODO: Grab param that is the page we're on so that we treat it differently visually in the list.
	function MakeNavColumn( $visitingPage )
	{
		class Page
		{
			public $url;
			public $label;
			public $description;
		};
		
		$pageArray = array();
		
		$page = new Page;
		$page->url = "index.php";
		$page->label = "Home";
		$page->description = "Introduce and explain the purpose of site.";
		array_push( $pageArray, $page );
		
		$page = new Page;
		$page->url = "GuestBook.php";
		$page->label = "Guest Book";
		$page->description = "Sign the guest-book while you're here.  It's stored in an SQL database.";
		array_push( $pageArray, $page );
		
		$page = new Page;
		$page->url = "JuliaFractalDemo.php";
		$page->label = "Julia Fractal Generator";
		$page->description = "Generate Julia fractals with AJAX.";
		array_push( $pageArray, $page );
		
		$page = new Page;
		$page->url = "maze.php";
		$page->label = "Maze Generator";
		$page->description = "Generate mazes with JavaScript.";
		array_push( $pageArray, $page );
		
		$page = new Page;
		$page->url = "LonePeak.php";
		$page->label = "Lone Peak Pictures";
		$page->description = "Flip through hike pictures with PHP.";
		array_push( $pageArray, $page );
		
		print "<ul>\n";
		
		foreach( $pageArray as $page )
		{
			print "<li>";
			if( $visitingPage == $page->label )
				print "<strong>";
			print "<a href=\"$page->url\">$page->label</a> -- $page->description";
			if( $visitingPage == $page->label )
				print "</strong>";
			print "</li>\n";
		}
		
		print "</ul>\n";
	}
?>