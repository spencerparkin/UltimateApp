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
	// After failing over and over to generate a data-URI, I ran into the
	// following method on stack-overflow.  I'm not yet sure exactly how or why it works.
	//
	
	var rawImageData = fractalRequest.response;
	var byteArray = new Uint8Array( rawImageData );
	var blob = new Blob( [ byteArray ], { 'type' : 'image/png' } );
	
	fractalImage.onerror = function()
	{
		alert( 'Failed to load image from data-URI.' );
	}
	
	var url = URL.createObjectURL( blob );	
	fractalImage.src = url;

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
// The problem with that, however, is that the page would be unresponsive until the browser
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
	fractalRequest.responseType = "arraybuffer";	// It may have also been useful to use "blob" here.
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