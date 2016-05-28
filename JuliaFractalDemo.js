// JuliaFractalDemo.js

var fractalRequest = null;

function FractalRequestResponder()
{
	//
	// Bail if we do not yet have all the image data.
	//
	
	if( fractalRequest == null )
		return;
	
	if( fractalRequest.readyState != 4 /*completed*/ )
		return;
	
	if( fractalRequest.status != 200 )
	{
		alert( "Error: " + fractalRequest.statusText );
		return;
	}
	
	//
	// Grab out canvas rendering context.
	//
	
	var canvas = document.getElementById( "canvas" );
	var context = canvas.getContext( '2d' );
	
	//
	// Make an image and setup to render into the canvas on image load.
	//
	
	var image = new Image();
	image.onload = function()
	{
		context.drawImage( image, 0, 0 );
	}
	
	//
	// Extract the PNG data and set to load it as the image source.
	//
	
	image.src = "data:image/png;" + fractalRequest.response;

	//
	// Tell the user we're done and update the status indicator.
	//
	
	var genStatus = document.getElementById( "genStatus" );
	genStatus.innerHTML = "Fractal image generation complete!";
	
	var genButton = document.getElementById( "genButton" );
	genButton.disabled = false;
	
	//
	// We're now done with our request object.
	//
	
	fractalRequest = null;
}

// Note that a better way to do this is probably not to make an AJAX call at all, but to
// have JavaScript just alter the HTML somewhere to be <img src="JuliaFractal.php?..."/>.
// The problem with that, however, is that the page would be inresponsive until the browser
// finished the request.  Because we're doing the request, the user can continue to use the
// page while the server generates the image.
function GenerateJuliaFractal()
{
	//
	// If there is already a request in progress, do nothing.
	//
	
	if( fractalRequest != null )
		return;
	
	//
	// Grab all the form data.
	//
	
	var xMin = document.getElementById( "xMin" ).value;
	var xMax = document.getElementById( "xMax" ).value;
	var yMin = document.getElementById( "yMin" ).value;
	var yMax = document.getElementById( "yMax" ).value;
	
	var imageWidth = document.getElementById( "imageWidth" ).value;
	var imageHeight = document.getElementById( "imageHeight" ).value;
	
	var maxIters = document.getElementById( "maxIters" ).value;
	
	var cReal = document.getElementById( "cReal" ).value;
	var cImag = document.getElementById( "cImag" ).value;
	
	//
	// Create our request object.
	//
	
	try
	{
		fractalRequest = new XMLHttpRequest();
	}
	catch( error )
	{
		alert( error );
		return;
	}
	
	//
	// Formulate our URL with the fractal parameters.
	//
	
	var url = "JuliaFractal.php"
	url += "?imageWidth=" + imageWidth;
	url += "&imageHeight=" + imageHeight;
	url += "&maxIters=" + maxIters;
	url += "&xMin=" + xMin;
	url += "&xMax=" + xMax;
	url += "&yMin=" + yMin;
	url += "&yMax=" + yMax;
	url += "&cReal=" + cReal;
	url += "&cImag=" + cImag;
	
	//
	// Send our request to the server.
	//
	
	fractalRequest.open( "GET", url, true );
	fractalRequest.onreadystatechange = FractalRequestResponder;
	//fractalRequest.responseType = 'blob';
	fractalRequest.send( null );
	
	//
	// Tell the user that we're waiting for the server.
	//
	
	var genStatus = document.getElementById( "genStatus" );
	genStatus.innerHTML = "Waiting for server to generate fractal image...";
	
	//
	// Disable the fractal generation button until we get our answer back from the server.
	//
	
	var genButton = document.getElementById( "genButton" );
	genButton.disabled = true;
}

// JuliaFractalDemo.js