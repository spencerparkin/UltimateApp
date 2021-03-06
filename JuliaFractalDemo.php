<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<title>Julia Fractal Demo</title>
	<script src="JuliaFractalDemo.js"></script>
	<link rel="stylesheet" type="text/css" href="UltimateStyle.css">
</head>

<body>

<div id="header">
	<h1>Julia Fractal Demo (v1.0)</h1>
</div>

<div id="navColumn">
	<?php
		include 'NavColumn.php';
		MakeNavColumn( "Julia Fractal Generator" );
	?>
</div>

<div id="content">
	<p>
	In this page I'm using AJAX (instead of a form submission or pure JavaScript) to let the user regenerate Julia-set fractals.
	When you push the "Generate!" button, an asynchronous request to generate the fractal image is sent to the server which, in turn,
	responds with an image in PNG format.  Once an image appears, try clicking on it to zoom in to the location under the cursor.
	</p>

	<form action="">
		<fieldset>
			<legend>Fractal image parameters</legend>
			<fieldset>
				<legend>Image Size</legend>
				<p>
					<label>Image Width: </label><input type="text" value="512" id="imageWidth"/>
				</p>
				<p>
					<label>Image Height: </label><input type="text" value="512" id="imageHeight"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>Window into the complex plane</legend>
				<p>
					<label>X-min: </label><input type="text" value="-2.0" id="xMin"/>
					<label>X-max: </label><input type="text" value="2.0" id="xMax"/>
				</p>
				<p>
					<label>Y-min: </label><input type="text" value="-2.0" id="yMin"/>
					<label>Y-max: </label><input type="text" value="2.0" id="yMax"/>
				</p>
				<p>
					<input type="button" value="Reset" onclick="OnResetButtonClicked()"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>Fractal parameters</legend>
				<p>
					<label>Max-Iters: </label><input type="text" value="200" id="maxIters"/>
				</p>
				<p>
					<label>C-real: </label><input type="text" value="-0.4" id="cReal"/>
					<label>C-imag: </label><input type="text" value="0.6" id="cImag"/>
				</p>
				<p>
					<label>Pre-programmed Julia set: </label>
					<select id="juliaDropdown" onchange="OnJuliaDropdownChanged( event )">
						<option value="1">Julia 1</option>
						<option value="2">Julia 2</option>
						<option value="3">Julia 3</option>
						<option value="4">Julia 4</option>
						<option value="5">Julia 5</option>
						<option value="6">Julia 6</option>
						<option value="7">Julia 7</option>
						<option value="8">Julia 8</option>
						<option value="9">Julia 9</option>
					</select>
				</p>
			</fieldset>
			<p>
				<input type="button" value="Generate!" onclick="GenerateJuliaFractal()" id="genButton"/>
				<label id="genStatus">Click the button!</label>
				<img src="16_cycle_one_24.gif" id="loadingIcon" hidden>
			</p>
		</fieldset>
	</form>

	<p>
		<img src="" id="fractalImage" onclick="OnFractalImageClicked( event )">
	</p>

	<h2>Discussion</h2>

	<p>
	Unlike the Mandelbrot set, there are many different kinds of Julia sets.  For every complex number C in
	the complex plane, there is a corresponding Julia set.  The most interesting such sets are found when C
	is chosen near the borders of the Mandelbrot set.  Anyhow, a Julia set is found as the set of all complex
	numbers Z that cannot escape an infinite number of orbits through the recursive equation Z -> Z<sup>2</sup> + C.
	Such a Z is said to never escape if its magnitude has an upper bound over all recursive iterations.
	It can be shown that if |Z| ever becomes greater than a certain size, then it will escape.
	More information can be found <a href="https://en.wikipedia.org/wiki/Julia_set" target="_blank">here</a>.
	</p>
</div>

<div id="footer">
	<p>
	Copyright (C) 2016, Spencer T. Parkin
	</p>
</div>

</body>

</html>