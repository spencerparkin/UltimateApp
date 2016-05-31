<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<title>Maze Demonstration</title>
	<script src="maze.js"></script>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
</head>
<body>

<div id="header">
	<h1>Maze Generator (v1.0)</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Maze Generator" );
	?>
</div>

<div id="content">
	<p>Use the form below to configure your maze, then push the "generate" button to be amazed!  Note that
	this page doesn't appear to fully work in Firefox, but it does work in Chrome.  I'm still trying to figure that out.</p>

	<form action="">
		<fieldset>
			<legend>Maze Controls</legend>
			<p><fieldset>
				<legend>Maze Type</legend>
				<input type="radio" name="radioMazeType" id="rectMazeTypeRadio" onclick="ToggleMazeType( event )" checked="checked"/>Rectangular
				<input type="radio" name="radioMazeType" id="circMazeTypeRadio" onclick="ToggleMazeType( event )"/>Circular
			</fieldset></p>
			<p><div id="RectangularMazeParameters">
				<fieldset>
					<legend>Rectangular Maze Parameters</legend>
					<label>Rows:</label>
					<input type="text" id="mazeRowsInput" value="10"/>
					<label>Columns:</label>
					<input type="text" id="mazeColsInput" value="20"/>
				</fieldset>
			</div></p>
			<p><div id="CircularMazeParameters" style="display:none;">
				<fieldset>
					<legend>Circular Maze Parameters</legend>
					<label>Rings:</label>
					<input type="text" id="mazeRingsInput" value="10"/>
				</fieldset>
			</div></p>
			<p>
				<input type="button" value="Generate!" onclick="GenerateMaze()"/>
				<input type="button" value="Draw Solution!" onclick="DrawSolution()"/>
			</p>
		</fieldset>
	</form>

	<p><canvas id="canvas" width="512" height = "512" style="border:1px solid #000000;">
	</canvas></p>

	<h2>Discussion</h2>

	<p>
	So what is a maze from a technical stand-point?  In the case above, a maze is
	a randomly generated spanning tree of a well connected graph.  In a connected
	graph, there exists a path from every vertex to every other vertex.  If for every
	pair of vertices, there are many pathways through the graph that connect them,
	then there is a higher variety of mazes we can generate from such a graph.
	</p>

	<p>
	To generate a random spanning we tree, we do nothing more than a random breadth-first
	traversal of the graph.  As we generate the spanning tree, each node in the tree points
	to its parent.  This makes generating a solution to the maze trivial in the case that
	the root serves as the starting point of the maze, and a leaf serves as the exit point.
	To draw the maze's solution, we simply begin at the leaf and follow its lineage all the
	way back to the root.  For circular mazes, the goal is to enter on the left, find the center,
	then exit on the right.  So the solution path may retrace itself.
	</p>

	<p>
	To me there is some question as to the whether the program is giving equal probability
	of generation to the set of all possible spanning trees.  With some tweaks of the algorithm,
	I could probably make the mazes a bit more interesting.  Most seem to have a fairly easy solution.
	</p>
</div>

<div id="footer">
	<p>Copyright (C) 2016, Spencer T. Parkin</p>
</div>

</body>
</html>