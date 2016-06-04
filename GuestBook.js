// GuestBook.js

function OnLoad()
{
	document.getElementById( 'criticalInfo' ).style.display = 'none';
	
	document.getElementById( 'minDate' ).value = "2015-01-01";
	document.getElementById( 'maxDate' ).value = "2020-01-01";
}

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
	var minDateStr = document.getElementById( "minDate" ).value;
	var maxDateStr = document.getElementById( "maxDate" ).value;
	
	if( isNaN( Date.parse( minDateStr ) ) )
	{
		alert( "Could not recognize \"" + minDateStr + "\" as a date." );
		return;
	}
	
	if( isNaN( Date.parse( maxDateStr ) ) )
	{
		alert( "Could not recognize \"" + maxDateStr + "\" as a date." );
		return;
	}
	
	var minDate = new Date( minDateStr );
	var maxDate = new Date( maxDateStr );
	
	if( !( minDate instanceof Date && isFinite( minDate ) ) )
	{
		alert( "Could not recognize \"" + minDateStr + "\" as a date." );
		return;
	}
	
	if( !( maxDate instanceof Date && isFinite( maxDate ) ) )
	{
		alert( "Could not recognize \"" + maxDateStr + "\" as a date." );
		return;
	}
	
	if( minDate.getTime() > maxDate.getTime() )
	{
		alert( "The min-date must be less than or equal to the max-date." );
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
		var signResponse = document.getElementById( "viewQueryResults" );
		signResponse.innerHTML = response;
	}
	
	var formData = "action=ViewGuestbookEntries";
	formData += "&minDate=" + minDateStr;
	formData += "&maxDate=" + maxDateStr;
	request.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );	// I should figure out how to send JSON.
	request.send( formData );
}

// GuestBook.js