// This is called by each radio button to toggle which maze parameters are presented to the user.
function ToggleMazeType( event )
{
	var rectMazeTypeRadio = document.getElementById( "rectMazeTypeRadio" );
	var circMazeTypeRadio = document.getElementById( "circMazeTypeRadio" );
	
	var enableParameterControls = null;
	var disableParameterControls = null;
	
	if( event.srcElement == rectMazeTypeRadio )
	{
		enableParameterControls = document.getElementById( "RectangularMazeParameters" );
		disableParameterControls = document.getElementById( "CircularMazeParameters" );
	}
	else if( event.srcElement == circMazeTypeRadio )
	{
		enableParameterControls = document.getElementById( "CircularMazeParameters" );
		disableParameterControls = document.getElementById( "RectangularMazeParameters" );
	}
	
	if( enableParameterControls && disableParameterControls )
	{
		enableParameterControls.style.display = "";
		disableParameterControls.style.display = "none";
	}
}

function RandomInteger( min, max )
{
	var randomInt = Math.floor( Math.random() * ( max - min ) ) + min;
	return randomInt;
}

var Maze =
{
	Generate : function()
	{
		this.nodeArray = [];
	
		if( arguments.length == 0 )
			return false;
		
		var type = arguments[0];
		
		if( type == "rect" )
		{
			if( arguments.length != 3 )
				return false;
			
			var rows = arguments[1];
			var cols = arguments[2];
			
			var matrix = new Array( rows );
			for( i = 0; i < rows; i++ )
			{
				matrix[i] = new Array( cols );
				for( j = 0; j < cols; j++ )
				{
					var node = new Object();
					node.x = j;
					node.y = i;
					node.adjacencies = [];
					node.parent = null;
					node.visited = false;
					node.queued = false;
					matrix[i][j] = node;
					this.nodeArray.push( node );
				}
			}
			
			for( i = 0; i < rows; i++ )
			{
				for( j = 0; j < cols; j++ )
				{
					var node = matrix[i][j];
					if( i > 0 )
						node.adjacencies.push( matrix[i-1][j] );
					if( i < rows - 1 )
						node.adjacencies.push( matrix[i+1][j] );
					if( j > 0 )
						node.adjacencies.push( matrix[i][j-1] );
					if( j < cols - 1 )
						node.adjacencies.push( matrix[i][j+1] );
				}
			}
			
			this.mazeExit = [];
			this.mazeExit.push( matrix[ rows - 1 ][ cols - 1 ] );
		}
		else if( type == "circ" )
		{
			if( arguments.length != 2 )
				return false;
			
			var rings = arguments[1];
			var radius = 0.0;
			var deltaRadius = 1.0;
			var nextArray = 1;
			var prevArray = 0;
			var ringArray = new Array(2);
			ringArray[0] = null;
			ringArray[1] = null;
			
			for( i = 0; i < rings; i++ )
			{
				nextArray = 1 - nextArray;
				prevArray = 1 - prevArray;
				
				var nodeCount = i * 7;
				
				ringArray[ nextArray ] = [];
				
				for( j = 0; j < nodeCount; j++ )
				{
					var angle = ( j / nodeCount ) * Math.PI * 2.0;
					var node = new Object();		// TODO: Write constructor.
					node.x = radius * Math.cos( angle );
					node.y = radius * Math.sin( angle );
					node.adjacencies = [];
					node.parent = null;
					node.visited = false;
					node.queued = false;
					this.nodeArray.push( node );
					ringArray[ nextArray ].push( node );
				}
				
				if( nodeCount > 1 )
				{
					for( j = 0; j < nodeCount; j++ )
					{
						var node = ringArray[ nextArray ][j];
						var nextNode = null;
						var prevNode = null;
						
						if( j > 0 )
							prevNode = ringArray[ nextArray ][ j - 1 ];
						else
							prevNode = ringArray[ nextArray ][ nodeCount - 1 ];
						
						if( j < nodeCount - 1 )
							nextNode = ringArray[ nextArray ][ j + 1 ];
						else
							nextNode = ringArray[ nextArray ][0];
						
						node.adjacencies.push( nextNode );
						node.adjacencies.push( prevNode );
					}
				}
				
				if( ringArray[ prevArray ] != null )
				{
					var eps = 0.01;
					
					for( j = 0; j < ringArray[ nextArray ].length; j++ )
					{
						var nodeA = ringArray[ nextArray ][j];
						
						for( k = 0; k < ringArray[ prevArray ].length; k++ )
						{
							var nodeB = ringArray[ prevArray ][k];
							
							var det = nodeA.x * nodeB.y - nodeA.y * nodeB.x;
							if( ( i < 4 && Math.abs( det ) >= eps ) || ( i >= 4 && Math.abs( det ) >= 2 ) )
								continue;
							
							var dot = nodeA.x * nodeB.x + nodeA.y * nodeB.y;
							if( dot < -eps )
								continue;
							
							nodeA.adjacencies.push( nodeB );
							nodeB.adjacencies.push( nodeA );
						}
					}
				}
				
				radius += deltaRadius;
			}
			
			this.mazeExit = [];
			this.mazeExit.push( ringArray[ nextArray ][0] );
			var index = Math.round( ringArray[ nextArray ].length / 2 );
			if( index >= ringArray[ nextArray ].length )
				index = ringArray[ nextArray ].length - 1;
			if( index != 0 )
				this.mazeExit.push( ringArray[ nextArray ][ index ] );
		}
		else
		{
			return false;
		}
		
		// Generate the maze by doing a random BFS.
		// Note that the maze solution is trivially found by following a node's lineage.
		var queue = [];
		var node = this.nodeArray[0];
		queue.push( node );
		node.queued = true;
		while( queue.length > 0 )
		{
			var index = RandomInteger( 0, queue.length - 1 );
			var node = queue.splice( index, 1 )[0];
			
			node.queued = false;
			node.visited = true;
			
			var visitedAdjacencies = [];
			for( i = 0; i < node.adjacencies.length; i++ )
			{
				var adjacentNode = node.adjacencies[i];
				if( adjacentNode.visited )
					visitedAdjacencies.push( adjacentNode );
			}
			
			if( visitedAdjacencies.length > 0 )
			{
				index = RandomInteger( 0, visitedAdjacencies.length - 1 );
				var adjacentNode = visitedAdjacencies[ index ];
				node.parent = adjacentNode;
			}
			
			for( i = 0; i < node.adjacencies.length; i++ )
			{
				var adjacentNode = node.adjacencies[i];
				if( !adjacentNode.visited && !adjacentNode.queued )
				{
					queue.push( adjacentNode );
					adjacentNode.queued = true;
				}
			}
		}
			
		return true;
	},
	
	CalcRegion : function()
	{
		var region = { xMin : 999, yMin : 999, xMax : 0, yMax : 0 };
	
		for( i = 0; i < this.nodeArray.length; i++ )
		{
			var node = this.nodeArray[i];
			
			if( node.x < region.xMin )
				region.xMin = node.x;
			if( node.x > region.xMax )
				region.xMax = node.x;
			if( node.y < region.yMin )
				region.yMin = node.y;
			if( node.y > region.yMax )
				region.yMax = node.y;
		}
		
		return region;
	},

	Draw : function( drawSolution )
	{
		var canvas = document.getElementById( "canvas" );
		if( canvas.getContext == null )
		{
			alert( "No context for canvas!" );
			return;
		}
		
		var context = canvas.getContext( '2d' );
		
		context.fillStyle = "#FFFFFF";
		context.fillRect( 0, 0, canvas.width, canvas.height );
		
		var region = this.CalcRegion();
		var margin = 1.0;
		
		region.xMin -= margin;
		region.xMax += margin;
		region.yMin -= margin;
		region.yMax += margin;
		
		var upperLeftCornerPoint = { x : region.xMin, y : region.yMin };
		var lowerRightCornerPoint = { x : region.xMax, y : region.yMax };
		
		var regionWidth = region.xMax - region.xMin;
		var regionHeight = region.yMax - region.yMin;
		
		var canvasAspectRatio = canvas.width / canvas.height;
		var regionAspectRatio = regionWidth / regionHeight;
		
		if( regionAspectRatio > canvasAspectRatio )
		{
			var deltaHeight = 0.5 * ( regionWidth / canvasAspectRatio - regionHeight );
			region.yMin -= deltaHeight;
			region.yMax += deltaHeight;
		}
		else
		{
			var deltaWidth = 0.5 * ( regionHeight * canvasAspectRatio - regionWidth );
			region.xMin -= deltaWidth;
			region.xMax += deltaWidth;
		}
		
		var LinearMap = function( point )
		{
			var lerpX = ( point.x - region.xMin ) / ( region.xMax - region.xMin );
			var lerpY = ( point.y - region.yMin ) / ( region.yMax - region.yMin );
			point.x = lerpX * canvas.width;
			point.y = lerpY * canvas.height;
			return point;
		}
		
		upperLeftCornerPoint = LinearMap( upperLeftCornerPoint );
		lowerRightCornerPoint = LinearMap( lowerRightCornerPoint );
		
		context.fillStyle = "#000000";
		context.fillRect( upperLeftCornerPoint.x, upperLeftCornerPoint.y,
							lowerRightCornerPoint.x - upperLeftCornerPoint.x,
							lowerRightCornerPoint.y - upperLeftCornerPoint.y );
		
		context.strokeStyle = "#FFFFFF";
		context.lineWidth = "10";		// Should be calculated, really.
		context.lineCap = "square";
		context.beginPath();
		
		var DrawStrokeToParent = function( node )
		{
			var parent = node.parent;
			if( parent != null )
			{
				var point = { x : node.x, y : node.y };
				point = LinearMap( point );
				
				var parentPoint = { x : parent.x, y : parent.y };
				parentPoint = LinearMap( parentPoint );
			
				context.moveTo( point.x, point.y );
				context.lineTo( parentPoint.x, parentPoint.y );
				context.stroke();
			}
		}
		
		for( i = 0; i < this.nodeArray.length; i++ )
		{
			var node = this.nodeArray[i];
			DrawStrokeToParent( node );
		}
		
		context.closePath();
		
		if( drawSolution )
		{
			context.strokeStyle = "#FF0000";
			context.lineWidth = "2";
			context.lineCap = "square";
			context.beginPath();
			
			for( i = 0; i < this.mazeExit.length; i++ )
			{
				var node = this.mazeExit[i];
				while( node != null )
				{
					DrawStrokeToParent( node );
					node = node.parent;
				}
			}
			
			context.closePath();
		}
	}
};

var theMaze = null;

// This is gets called when the "generate" button is pushed.
function GenerateMaze( event )
{
	theMaze = Object.create( Maze );

	var rectMazeTypeRadio = document.getElementById( "rectMazeTypeRadio" );
	var circMazeTypeRadio = document.getElementById( "circMazeTypeRadio" );

	if( rectMazeTypeRadio.checked )
	{
		var mazeRowsInput = document.getElementById( "mazeRowsInput" );
		var mazeColsInput = document.getElementById( "mazeColsInput" );
		
		var rows = parseInt( mazeRowsInput.value );
		var cols = parseInt( mazeColsInput.value );
		
		if( rows <= 0 || cols <= 0 || rows > 30 || cols > 30 )
		{
			alert( "Can't generate a maze with " + rows + " row(s) and " + cols + " column(s).  (Max dimension is 30.)" );
			return;
		}
	
		theMaze.Generate( "rect", rows, cols );
	}
	else if( circMazeTypeRadio.checked )
	{
		var mazeRingsInput = document.getElementById( "mazeRingsInput" );
		
		var rings = parseInt( mazeRingsInput.value );
		
		if( rings <= 0 || rings > 15 )
		{
			alert( "Can't generate a maze with " + rings + " ring(s).  (Max dimension is 15.)" );
			return;
		}
	
		theMaze.Generate( "circ", rings );
	}
	else
	{
		alert( "Unknown maze type." );
		return;
	}
	
	theMaze.Draw( false );
}

function DrawSolution( event )
{
	if( theMaze == null )
	{
		alert( "You must first generate a maze." );
		return;
	}
	
	theMaze.Draw( true );
}