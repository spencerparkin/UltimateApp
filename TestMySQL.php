<?php
	$url = parse_url( getenv( "DATABASE_URL" ) );
	
	foreach( $url as $key => $value )
	{
		print "$key => $value</br>";
	}
?>