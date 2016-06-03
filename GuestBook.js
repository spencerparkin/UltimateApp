// GuestBook.js

function AddEntry()
{
	// This is the extent of our catcha test.  If the bot didn't fill this in, however, the test fails us.
	var criticalInfo = document.getElementById( "criticalInfo" );
	if( 0 != criticalInfo.value.length )
		return;
	
	var guestName = document.getElementById( "guestName" );
	if( 0 == guestName.value.length )
	{
		alert( "Please provide your name." );
		return;
	}
	
	var guestMessage = document.getElementById( "guestMessage" );
	if( 0 == guestMessage.value.length )
	{
		alert( "Please provide a message." );
		return;
	}
	
	var request = null;
	
	try
	{
		request = new XMLHttpRequest();
	}
	catch( error )
	{
		alert( error );
		return;
	}
	
	var url = "GuestBookBackend.php";
	request.open( "POST", url, true );
	
	request.onload = function()
	{
		var response = this.responseText;
		var signResponse = document.getElementById( "signResponse" );
		signResponse.innerHTML = "<p>" + response + "</p>";
		
		if( response == "Guestbook signed!" )
		{
			guestName.value = "";
			guestMessage.value = "";
		}
	}
	
	var formData = "action=AddGuestbookEntry";
	formData += "&name=" + guestName.value;
	formData += "&message=" + encodeURIComponent( guestMessage.value );
	request.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
	request.send( formData );
}

function ViewEntries()
{
	alert( "No yet supported...comming soon.  (I'm sure the aniticpation is killing you.)" );
}

// GuestBook.js