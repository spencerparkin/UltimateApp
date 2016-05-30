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
	
	var fractalImage = document.getElementById( "fractalImage" );
	fractalImage.onerror = function()
	{
		alert( 'Failed to load image.' );
	}
	
	var url = URL.createObjectURL( blob );	
	fractalImage.src = url;

	//
	// Tell the user we're done and update the status indicator.
	//
	
	var genStatus = document.getElementById( "genStatus" );
	genStatus.innerHTML = "Fractal image generation complete!";
	
	var loadingIcon = document.getElementById( "loadingIcon" );
	loadingIcon.hidden = true;
	
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
	
	var loadingIcon = document.getElementById( "loadingIcon" );
	loadingIcon.hidden = false;
	
	//
	// Disable the fractal generation button until we get our answer back from the server.
	//
	
	var genButton = document.getElementById( "genButton" );
	genButton.disabled = true;
}

function OnFractalImageClicked( event )
{
	var xMinEle = document.getElementById( "xMin" );
	var xMaxEle = document.getElementById( "xMax" );
	var yMinEle = document.getElementById( "yMin" );
	var yMaxEle = document.getElementById( "yMax" );
	
	var xMin = parseFloat( xMinEle.value );
	var xMax = parseFloat( xMaxEle.value );
	var yMin = parseFloat( yMinEle.value );
	var yMax = parseFloat( yMaxEle.value );
	
	var fractalImage = document.getElementById( "fractalImage" );
	
	var imageWidth = fractalImage.width;
	var imageHeight = fractalImage.height;
	
	var xDelta = xMax - xMin;
	var yDelta = yMax - yMin;
	
	var xLerp = event.offsetX / imageWidth;
	var yLerp = 1.0 - event.offsetY / imageHeight;
	
	var xClick = xMin + xLerp * xDelta;
	var yClick = yMin + yLerp * yDelta;
	
	xMin = xClick - xDelta / 6.0;
	xMax = xClick + xDelta / 6.0;
	yMin = yClick - yDelta / 6.0;
	yMax = yClick + yDelta / 6.0;
	
	xMinEle.value = xMin.toString();
	xMaxEle.value = xMax.toString();
	yMinEle.value = yMin.toString();
	yMaxEle.value = yMax.toString();
	
	GenerateJuliaFractal();
}

function OnJuliaDropdownChanged( event )
{
	var juliaDropdown = document.getElementById( "juliaDropdown" );
	var juliaType = parseInt( juliaDropdown.value );
	
	var cReal = 0.0;
	var cImag = 0.0;
	
	switch( juliaType )
	{
		case 1:
		{
			cReal = -0.4;
			cImag = 0.6;
			break;
		}
		case 2:
		{
			cReal = 0.285;
			cImag = 0.0;
			break;
		}
		case 3:
		{
			cReal = 0.285;
			cImag = 0.01;
			break;
		}
		case 4:
		{
			cReal = 0.45;
			cImag = 0.1428;
			break;
		}
		case 5:
		{
			cReal = -0.70176;
			cImag = -0.3842;
			break;
		}
		case 6:
		{
			cReal = -0.835;
			cImag = -0.2321;
			break;
		}
		case 7:
		{
			cReal = -0.8;
			cImag = 0.156;
			break;
		}
		case 8:
		{
			cReal = -0.7269;
			cImag = 0.1889;
			break;
		}
		case 9:
		{
			cReal = 0.0;
			cImag = 0.8;
			break;
		}
	}
	
	document.getElementById( "cReal" ).value = cReal.toString();
	document.getElementById( "cImag" ).value = cImag.toString();
	
	ResetDomainAndRange();
}

function ResetDomainAndRange()
{
	var xMinEle = document.getElementById( "xMin" );
	var xMaxEle = document.getElementById( "xMax" );
	var yMinEle = document.getElementById( "yMin" );
	var yMaxEle = document.getElementById( "yMax" );
	
	xMinEle.value = "-2.0";
	xMaxEle.value = "2.0";
	yMinEle.value = "-2.0";
	yMaxEle.value = "2.0";
}

function OnResetButtonClicked()
{
	ResetDomainAndRange();
}

// JuliaFractalDemo.js