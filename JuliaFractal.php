<?php
	
	//
	// Grab our parameters from the URL.
	//
	
	class Parameters
	{
		public $imageWidth;
		public $imageHeight;
		public $xMin;
		public $xMax;
		public $yMin;
		public $yMax;
		public $cReal;
		public $cImag;
		public $maxIters;
	};
	
	$parameters = new Parameters();
	$parameters->imageWidth = filter_input( INPUT_GET, "imageWidth" ) or die( "No imageWidth given." );
	$parameters->imageHeight = filter_input( INPUT_GET, "imageHeight" ) or die( "No imageHeight given." );
	$parameters->xMin = filter_input( INPUT_GET, "xMin" ) or die( "No xMin given." );
	$parameters->xMax = filter_input( INPUT_GET, "xMax" ) or die( "No xMax given." );
	$parameters->yMin = filter_input( INPUT_GET, "yMin" ) or die( "No yMin give." );
	$parameters->yMax = filter_input( INPUT_GET, "yMax" ) or die( "No yMax given." );
	$parameters->cReal = filter_input( INPUT_GET, "cReal" ) or die( "No cReal given." );
	$parameters->cImag = filter_input( INPUT_GET, "cImag" ) or die( "No cImag given." );
	$parameters->maxIters = 200;
	
	//
	// Create our image in the desired dimensions.
	//
	
	$image = @imagecreatetruecolor( $parameters->imageWidth, $parameters->imageHeight ) or die( "Failed to create GD image." );
	
	//
	// Generate our color look-up table.
	//
	
	$colorTableSize = 512;
	$colorTable = array();
	
	$colorPoints =
	[
		0 => array( 0xFF, 0x00, 0x00 ),		// Red.
		1 => array( 0xFF, 0xA5, 0x00 ),		// Orange.
		2 => array( 0xFF, 0xFF, 0x00 ),		// Yellow.
		3 => array( 0x00, 0xFF, 0x00 ),		// Green.
		4 => array( 0x00, 0x00, 0xFF ),		// Blue.
		5 => array( 0x4B, 0x00, 0x82 ),		// Indigo.
		6 => array( 0x8A, 0x2B, 0xE2 ),		// Violet.
	];
	
	$numColorPoints = count( $colorPoints );
	
	$colorRampSize = ceil( $colorTableSize / $numColorPoints );
	
	for( $i = 0; $i <= $colorTableSize; $i++ )
	{
		$quotient = floor( $i / $colorRampSize );
		$remainder = fmod( $i, $colorRampSize );
		
		$colorPointA = $colorPoints[ $quotient ];
		$colorPointB = $colorPoints[ ( $quotient + 1 ) % $numColorPoints ];
		
		$lerp = $remainder / $colorRampSize;
		
		$r = $colorPointA[0] + $lerp * ( $colorPointB[0] - $colorPointA[0] );
		$g = $colorPointA[1] + $lerp * ( $colorPointB[1] - $colorPointA[1] );
		$b = $colorPointA[2] + $lerp * ( $colorPointB[2] - $colorPointA[2] );
		
		$color = imagecolorallocate( $image, $r, $g, $b );
		
		$colorTable[ $i ] = $color;
	}
	
	$colorBlack = imagecolorallocate( $image, 0, 0, 0 );
	
	//
	// Generate the fractal image.
	//
	
	function TestPixel( $parameters, $row, $col )
	{
		$zReal = $parameters->xMin + ( $col / $parameters->imageWidth ) * ( $parameters->xMax - $parameters->xMin );
		$zImag = $parameters->yMin + ( 1.0 - $row / $parameters->imageHeight ) * ( $parameters->yMax - $parameters->yMin );
		
		$i = 0;
		
		while( $i < $parameters->maxIters )
		{
			$squareMag = $zReal * $zReal + $zImag * $zImag;
			if( $squareMag > 5.0 )
				break;
			
			// Calculate Z -> Z^2 + C.
			
			$newReal = $zReal * $zReal - $zImag * $zImag + $parameters->cReal;
			$newImag = 2.0 * $zReal * $zImag + $parameters->cImag;
			
			$zReal = $newReal;
			$zImag = $newImag;
			
			$i++;
		}
		
		return $i;
	}
	
	for( $row = 0; $row < $parameters->imageHeight; $row++ )
	{
		for( $col = 0; $col < $parameters->imageWidth; $col++ )
		{
			$i = TestPixel( $parameters, $row, $col );
			
			if( $i == $parameters->maxIters )
				$color = $colorBlack;
			else
				$color = $colorTable[ $i % $colorTableSize ];
			
			imagesetpixel( $image, $col, $row, $color );
		}
	}
	
	//
	// Write the image to the browser.
	//
	
	header( "Content-type: image/png" );
	imagepng( $image );
	
	//
	// Free all resources allocated.
	//
	
	for( $i = 0; $i <= $colorTableSize; $i++ )
	{
		$color = $colorTable[i];
		imagecolordeallocate( $image, $color );
	}
	
	imagecolordeallocate( $image, $colorBlack );
	imagedestroy( $image );
?>