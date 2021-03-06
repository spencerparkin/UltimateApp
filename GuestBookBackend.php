<?php

	/*
	create table entries ( id int not null auto_increment,
			name char(50) not null,
			sign_date date not null,
			sign_time time not null,
			message char(255) not null,
			primary key (id) ) engine=InnoDB;
	*/
	
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
			
			$hostname = "us-cdbr-iron-east-04.cleardb.net";
			$username = "b724b0bdcfed8d";
			$password = "06378b62";
			$dbname = "heroku_5f992fd1e502032";
			
			//$hostname = "localhost";
			//$username = "root";
			//$password = "BarfAlot";
			//dbname = "guestbook";
			
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
				return false;
			}
			
			return true;
		}
		
		function Query( $sqlStatement )
		{
			$result = null;
			
			try
			{
				$result = $this->pdoObject->query( $sqlStatement );
			}
			catch( PDOEXCEPTION $exceptoin )
			{
				$this->error = $exceptoin->getMessage();
				return null;
			}
			
			return $result;
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
		
		print "Guestbook signed!";
		exit;
	}
	
	function ViewGuestbookEntries()
	{
		$db = new Database();
		if( !$db->Connect() )
			die( "Failed to connect to the database ($db->error)" );
		
		global $inputMethod;
		
		$minDate = filter_input( $inputMethod, "minDate", FILTER_SANITIZE_STRING );
		$maxDate = filter_input( $inputMethod, "maxDate", FILTER_SANITIZE_STRING );
		
		$sqlStatement = "select * from entries where sign_date between '$minDate' and '$maxDate';";
		$result = $db->Query( $sqlStatement );
		if( $result == null )
			die( "Failed to perform SQL query." );
		
		$db->Disconnect();
		
		$count = count( $result );
		
		if( $count == 0 )
			print "<p>No results found!</p>";
		else
		{
			$count = 0;
			
			foreach( $result as $row )
			{
				$name = $row[ 'name' ];
				$message = $row[ 'message' ];
				$date = $row[ 'sign_date' ];
				$time = $row[ 'sign_time' ];
				
				print "<p>On $date at $time, <strong>$name</strong> said, \"$message\"<p>";
				
				$count++;
			}
			
			if( $count == 0 )
				print "<p>No results found!</p>";
			else if( $count == 1 )
				print "<p>$count entry found.</p>";
			else
				print "<p>$count entries found.</p>";
		}
		
		exit;
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