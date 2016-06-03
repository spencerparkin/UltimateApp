<?php

	define( 'deployed', false );
	
	class Database
	{
		public $error = null;
		private $pdoObject = null;
		
		function Connect()
		{
			global $deployed;
			
			if( isset( $this->pdoObject ) )
			{
				$error = "Already connected.";
				return false;
			}
			
			//
			// Determine the database connection parameters.
			//
			
			$hostname = null;
			$username = null;
			$password = null;
			$dbname = null;
			
			if( $deployed )
			{
				$url = parse_url( getenv( "DATABASE_URL" ) );
		
				$hostname = $url[ "host" ];
				$username = $url[ "user" ];
				$password = $url[ "pass" ];
				$dbname = substr( $url[ "path" ], 1 );
			}
			else
			{
				$hostname = "localhost";
				$username = "root";
				$password = "BarfAlot";
				$dbname = "guestbook";
			}
			
			//
			// Try to connect to the database.
			//
			
			try
			{
				$this->pdoObject = new PDO( "mysql:host=$hostname;dbname=$dbname", $username, $password );
				$this->pdoObject->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			catch( PDOException $exception )
			{
				$this->error = $exception->getMessage();
				$this->pdoObject = null;
				return false;
			}
			
			return true;
		}
		
		function Disconnect()
		{
			if( !isset( $this->pdoObject ) )
			{
				$this->error = "Not connected.";
				return false;
			}
			
			// Not sure if this will get garbage collected immediately.
			// The connection won't get closed until that happens.
			unset( $this->pdoObject );
			
			return true;
		}
		
		function Execute( $sqlStatement )
		{
			try
			{
				$this->pdoObject->exec( $sqlStatement );
			}
			catch( PDOExceptoin $exception )
			{
				$this->error = $exception->getMessage();
				$this->pdoObject = null;
				return false;
			}
			
			return true;
		}
	}

	function AddGuestbookEntry()
	{
		$db = new Database();
		if( !$db->Connect() )
			die( "Failed to connect to the database ($db->error)" );
		
		global $inputMethod;
		
		$name = filter_input( $inputMethod, "name", FILTER_SANITIZE_STRING );
		$message = filter_input( $inputMethod, "message", FILTER_SANITIZE_STRING );
		
		$sqlStatement = "insert into entries( id, name, sign_date, sign_time, message ) values( null, \"$name\", curdate(), curtime(), \"$message\" );";
		if( !$db->Execute( $sqlStatement ) )
			die( "Failed to insert new row ($db->error)" );
		
		$db->Disconnect();
		return true;
	}
	
	function ViewGuestbookEntries( $minDate, $maxDate )
	{
		// TODO: Write this.
	}
	
	//
	// Main entry point: perform the requested action.
	//
	
	$inputMethod = null;
	
	if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
		$inputMethod = INPUT_POST;
	else if( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' )
		$inputMethod = INPUT_GET;
	
	$action = filter_input( $inputMethod, "action" );
	
	if( $action == "AddGuestbookEntry" )
		AddGuestbookEntry();
	else if( $action == "ViewGuestbookEntries" )
		ViewGuestbookEntries();
	else
		die( "Unknown action: $action" );
?>