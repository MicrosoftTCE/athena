<!DOCTYPE html>
<html lang="en">
   <head>
      	<title></title>

      	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      	<link type="text/css" rel="stylesheet" href="stylesheets/reset.css" />
      		<link type="text/css" rel="stylesheet" href="stylesheets/normalize.css"/>
	<link type="text/css"  rel="stylesheet" href="stylesheets/Metro-UI-CSS-master/css/metro-bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/Metro-UI-CSS-master/css/metro-bootstrap-responsive.css"/>
	<link type="text/css" rel="stylesheet" href="stylesheets/font-awesome/css/font-awesome.min.css"/>
	<script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/jquery.min.js"></script>
    	<script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/jquery.widget.min.js"></script>
    	<script type="text/javascript" src="stylesheets/Metro-UI-CSS-master/min/metro.min.js"></script>

      	      	<script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>


    	
    	
      	<script type="text/javascript">

      		var map = null;
      		var queries = [];
      		var entities = []; 
      		var locEntities = [];
      		var entityNames = "";
      	
      		var locations = [];
      		var citiesOnly = [];
      		var storeTemp = [];
      	
        	function GetMap()
         	{
	            map = new Microsoft.Maps.Map(document.getElementById("mapDiv"), {credentials:"AjnijhbNF36AvIs3jD727fsUp2_JyQ7B5Q42pFzQG0eOYScZmRVjXKG0f1mfb3RU"});
         	
	         	map.setView({zoom:4, center: new Microsoft.Maps.Location(39.8282, -98.5795)});

	         	$(document).ready(function()
	         	{
	         		$.ajax({
	         			type:"GET",
	         			url:"data/athena_master.csv",
	         			dataType: "text",
	         			success:function(data) {retrieveAddr(data);}
	         		});
	         	});

	         	function retrieveAddr(csvContent)
	         	{
	         		var rows = csvContent.split("\n");
					var storeObjs = [];
					var headerString = rows[0];
					var index = headerString.indexOf("\"");
					while(index != -1)
					{
						headerString = headerString.replace("\"", "");
						index = headerString.indexOf("\"");
					}

					var headers = headerString.split(",");

					// var headers = rows[0].match(/(".*?"|[^",\s]+)(?=\s*,|\s*$)/g);
					// headers = headers || [];

					//	Renaming columns for JSON file.
					for(var count = 0; count < headers.length; count++)
					{
						headers[count] = headers[count].replace(/^\s*/, "").replace(/\s*$/, "");
						if(headers[count] === "Category")
						headers[count] = "categories";
						if(headers[count] === "Entity Name")
							headers[count] = "name";
						if(headers[count] === "Nickname")
							headers[count] = "nickname";
						if(headers[count] === "Location")
							headers[count] = "location";
						if(headers[count] === "Funding Received")
							headers[count] = "fundingR";
						if(headers[count] === "Investment Received")
							headers[count] = "investmentR";
						if(headers[count] === "Year Funding Received")
							headers[count] = "yearFR";
						if(headers[count] === "Year Investment Received")
							headers[count] = "yearIR";
						if(headers[count] === "Key People")
							headers[count] = "people";
						if(headers[count] === "Affiliations")
							headers[count] = "affil";
						if(headers[count] === "Related To")
							headers[count] = "relatedto"
						if(headers[count] === "Collaboration")
							headers[count] = "poruc";
						if(headers[count] === "Website")
							headers[count] = "weblink";
						if(headers[count] === "Year of Revenue and Expenses (Budget)")
							headers[count] = "randeY";
						if(headers[count] === "Revenue and Expenses (Budget)")
							headers[count] = "rande";
						if(headers[count] === "Funding Given")
							headers[count] = "grantsG";
						if(headers[count] === "Year of Funding Given")
							headers[count] = "yearG";
						if(headers[count] === "Number of Employees")
							headers[count] = "numemp";
						if(headers[count] === "Tags")
							headers[count] = "tags";
						if(headers[count] === "Twitter Handle")
							headers[count] = "twitterH";
						if(headers[count] === "Number of Twitter Followers")
							headers[count] = "followers";
						if(headers[count] === "Type of Entity")
							headers[count] = "type";
						if(headers[count] === "Global or Local Relevance")
							headers[count] = "golr";
					}

					//	Rows
					for(var countR = 1; countR < rows.length; countR++)
					{
						var jsonObj = {};
						var currentRow = rows[countR].match(/("[^"]+"|[^,]+)/g);
						//(".*?"|[^",\s]+)(?=\s*,|\s*$)
						currentRow = currentRow || [];
						
						//	Columns
						for(var countC = 0; countC < headers.length; countC++)
						{
							jsonObj[headers[countC]] = currentRow[countC];
							// document.write(jsonObj[headers[countC]]);
						}
						
						storeObjs.push(jsonObj);
					}
				
					var stringJSON = JSON.stringify(storeObjs, null);
					var index1 = stringJSON.indexOf("\\\"");
					var index2 = stringJSON.indexOf("\\r");
					while(index1 != -1 || index2 != -1)
					{
						stringJSON = stringJSON.replace("\\\"", "");
						stringJSON = stringJSON.replace("\\r", "");
						index1 = stringJSON.indexOf("\\\"");
						index2 = stringJSON.indexOf("\\r", "");
					}
					
					entities = JSON.parse(stringJSON);

					// randomString = stringJSON;
					// document.getElementById('random').innerHTML = randomString;
				}
			}

			function findLocation()
			{
			    map.getCredentials(callSearchService);  
			}

			function callSearchService(credentials) 
		    {
		      	var searchRequest;
		      	var mapscript;

		      	for(var count = 0; count < entities.length; count++)
		      	{
		      		if(entities[count].name !== undefined)
		      		{
		      		var temp = [];
		      		temp = (entities[count].location).split("; ");
		      		}
		      		for(var i=0;i<temp.length;i++)
		      		{
		      			if(temp[i] !== "null")
		      			{
		      				queries.push({
		      					nameKey: entities[count].name,
		      					locVal: temp[i]
		      				}); 
		      			}
		      		}
		      	}

		      	for(var count = 0; count < queries.length; count++)
		      	{
					// if(queries[count].locVal !== "null")
		   			// {
		      		entitiesForCity(queries[count].locVal);
		      		citiesOnly.push(queries[count].locVal);
		      	}
				//	This is ALL DONE, followed searchServiceCallback.
			  	for(var count = 0; count < queries.length; count++)
		      	{
					// if(queries[count].locVal !== "null")
					// {
				   	// 		entitiesForCity(queries[count].locVal);
				    searchRequest = 'http://dev.virtualearth.net/REST/v1/Locations/' + queries[count].locVal + '?output=json&jsonp=searchServiceCallback&key=' + credentials;

					mapscript = document.createElement('script'); 
			        mapscript.type = 'text/javascript'; 
			        mapscript.src = searchRequest; 
			        document.getElementById('mapDiv').appendChild(mapscript);

		      		// }
		      	}
		    }

	      	var pinInfoBox;
	      	function searchServiceCallback(result)
	     	{
	      		var location = new Microsoft.Maps.Location(result.resourceSets[0].resources[0].point.coordinates[0], result.resourceSets[0].resources[0].point.coordinates[1]);
		  		
	      		//	No duplication of city
		  		if(noDuplicatePins(citiesOnly, result.resourceSets[0].resources[0].name))
		  		{
		  			locations.push(location);
			  		pushStuff();
		  		}
		  		//	First: Duplication of city
		  		//	Second: DO ONCE
		  		else
		  		{
		  			if(storeTemp.indexOf(result.resourceSets[0].resources[0].name) === -1)
		  			{ 
		  				storeTemp.push(result.resourceSets[0].resources[0].name);
			  			pushStuff();
		  			}
		  		}

		  		function pushStuff()
		  		{
		  			locations.push(location);
				    //	Add pushpin for corresponding location.
				  	//  var pushPin = new Microsoft.Maps.Pushpin(location, {icon: "images/circle-icon.png", height:10, width:10, anchor: new 
					// 	Microsoft.Maps.Point(10,10)});
					// 	var pushPin = new Microsoft.Maps.Pushpin(location);
					//	Add information box to give context to corresponding pushpin.
					pinInfoBox = createPinInfoBox(result, location);

					// 	addActionAndItems(pushPin, pinInfoBox);
					//	Click on push pin.
					// 	Microsoft.Maps.Events.addHandler(pushPin, 'click', displayInfoBox);
					Microsoft.Maps.Event.addHandler(pointCenter, 'click', displayInfoBox);
					//	Add event handler
					Microsoft.Maps.Events.addHandler(map, 'viewchange', viewChangeMethod);
				  	map.entities.push(pushPin);
			      	map.entities.push(pinInfoBox);
	      	
					// 	var numOrg = (resultObject.listEnts).split("<br/>").length;
 					//	Draw the circle
					// 	drawCircle(10 * numOrg, result.resourceSets[0].resources[0].name);
		  		}

				function getTextFromHyperlink(linkText) 
				{
    				return linkText.match(/<a [^>]+>([^<]+)<\/a>/)[1];
				}			      	 

	    		function viewChangeMethod(e)
        		{
			 	   	pinInfoBox.setOptions({visible:false});
			 	}

        		function noDuplicatePins(array, location)
        		{
        			for(var i = 0; i < array.length; i++)
        			{	if(array.indexOf(location) !== array.lastIndexOf(location))
        				{
        					return false;
        				}
        			}
        			return true;
        		}
	  		}

	 	    //http://social.msdn.microsoft.com/Forums/en-US/d380ebc8-05e2-4149-bd59-463d96995649/draw-a-circle-on-bing-map?forum=bingmapsajax
		    function drawCircle(radius, origin, shape) 
		    {
			    var RadPerDeg = Math.PI / 180;
			    var earthRadius = 3959;  
			    var lat = origin.latitude * RadPerDeg;
			    var lon = origin.longitude * RadPerDeg;
			    var locs = new Array();
			    var AngDist = parseFloat(radius) / earthRadius;
			    for (x = 0; x <= 360; x++) { //making a 360-sided polygon
			        var pLatitude, pLongitude;
			        // With a nice, flat earth we could just say p2.Longitude = lon * sin(brng) and p2.Latitude = lat * cos(brng)
			        // But it ain't, so we can't.  See http://www.movable-type.co.uk/scripts/latlong.html
			        brng = x * RadPerDeg;
			        pLatitude = Math.asin(Math.sin(lat) * Math.cos(AngDist) + Math.cos(lat) * Math.sin(AngDist) * Math.cos(brng)); //still in radians
			        pLongitude = lon + Math.atan2(Math.sin(brng) * Math.sin(AngDist) * Math.cos(lat), Math.cos(AngDist) - Math.sin(lat) * Math.sin(pLatitude));
			        pLatitude = pLatitude / RadPerDeg;
			        pLongitude = pLongitude / RadPerDeg;
			        locs.push(new Microsoft.Maps.Location(pLatitude, pLongitude));
			    };

			    if(shape === "circle")
			    {
				    circle = new Microsoft.Maps.Polygon(locs, { visible: true, strokeThickness: 0.5, stroke: "1", fillColor:new Microsoft.Maps.Color(100, 0, 166, 240), strokeColor: new Microsoft.Maps.Color(250, 255, 255, 255) });   // a:opacity, r:red, g:green, b:blue
			    }
			    if(shape === "point")
			    {
				    circle = new Microsoft.Maps.Polygon(locs, { visible: true, strokeThickness: 4, stroke: "4", fillColor:new Microsoft.Maps.Color(255, 255, 255, 255), strokeColor: new Microsoft.Maps.Color(255, 255, 255, 255) });   // a:opacity, r:red, g:green, b:blue
				}
			    map.entities.push(circle);

			    return circle;
			}

			function displayInfoBox(e) 
			{
		        pinInfoBox.setOptions({ visible:true });
		    }
	 	
			var pointCenter;
	     	
	     	function createPinInfoBox(result, location)
	 	    {
	 	        	  	var resultObject = locEntities.filter(function(resultObject)
	 	        	  									{
	 	        	  										return resultObject.location === result.resourceSets[0].resources[0].name;
	 	        	  									})[0];	 	        // 	  	cool+= "\"" + "\"" + "\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" + result.resourceSets[0].resources[0].name +"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\";
				      	// document.getElementById('random').innerHTML = cool + x;

				
				      	// 	x = locEntities.indexOf(result.resourceSets[0].resources[0].name);

				      	// 	  	cool+="\"" + "\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" + result.resourceSets[0].resources[0].name +"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\";
				      	// document.getElementById('random').innerHTML = cool;

				      	 var numOrg = (resultObject.listEnts).split("<br/>").length;

							      	// //	Draw the circle
							  		 var circleProp = drawCircle(10 * numOrg,location, "circle");
							  		 var pointCenter = drawCircle(1, location, "point");
							  		 // drawCircle(200 * numOrg / map.getZoom(), pushPin.getLocation());
							  		         Microsoft.Maps.Events.addHandler(map, 'viewchangeend', viewChanged);


	 	        	  		return new Microsoft.Maps.Infobox(location,
											{
												title: result.resourceSets[0].resources[0].name,
												description: resultObject.listEnts,
												visible: false,
												offset: new Microsoft.Maps.Point(0,15)
											});
	 	        	  }

	 	        	  var lastZoomLevel = 0;
		 	        	  function viewChanged(e)
		 	        	  {
		 	        	  	if(lastZoomLevel !== map.getZoom()){
		 	        	  		lastZoomLevel = map.getZoom();
		 	        	  		alert("Map Zoomed. Level: " + lastZoomLevel);

		 	        	  	}
		 	        	  }

						function entitiesForCity(loc)
	 	        		{
	 	        			entityNames = "";
	 	        			entities.filter(function(obj)
	 	        			{
	 	        				if(obj.location !== undefined)
	 	        				{
	 	        				if((obj.location).indexOf(loc) !== -1)
	 	        					
	 	        					entityNames += "<span style='font-size:10px;'>" + '<a href="http://www.bing.com/search?q=' + (obj.name).replace(" ", "%20") + '&go=Submit&qs=bs&form=QBRE" target="_blank">' + obj.name + '</a>' + "</span><br/>";

	 	        				}
	 	        			});

								locEntities.push({
					      					location: loc,
					      					listEnts: entityNames
					      				}); 

	 	        		}
 	        		

 	        	
      </script>
      <style>
      	@import url(http://ecn.dev.virtualearth.net/mapcontrol/v7.0/7.0.2014071064147.83/css/en/mapdelay.css);
      	@import url(http://ecn.dev.virtualearth.net/mapcontrol/v7.0/7.0.2014071064147.83/css/en/mapcontrol.css);

      		.infobox-close{
      			text-transform: uppercase;
      			font-family: Helvetica, Verdana, sans-serif;
      		}

      		.infobox-body .infobox-title{
      			padding: 10px 0px 0px 0px;
      		}

      		.Infobox{
      			overflow-x:hidden;
      			overflow-y:scroll;
      		}

  

      		#random{
      			z-index: 999;
      		}
      		a {
      			text-decoration:none;
      			color: #666666;
      		}
      		.metro .for-profit{
      			background-color:rgb(127,186,0) !important;
      		}
      		.metro .non-profit{
      			background-color:rgb(0,164,239) !important;
      		}
      		.metro .individuals{
      			background-color:rgb(255,185,0) !important;
      		}
      		.metro .government{
      			background-color:rgb(242,80,34) !important;
      		}
      		path:hover{
      			fill-opacity:1;
      		}
      	</style>

   </head>
   <body onload="GetMap(); findLocation();" class="metro"> 
      <div id='mapDiv' style="position:absolute; width:100%; height:80%;"></div>
      <div class="grid fluid" style="top:80%; position:absolute;">
      	<div class="row">
      		<div class="span3">
      			<div class="panel" data-role="panel">
					<div class="panel-header fg-white for-profit">
						For-Profit<span id="fp-count"></span>
					</div>
					<div class="panel-content" style="display: none;">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
					</div>
				</div>
			</div>
			<div class="span3">
      			<div class="panel" data-role="panel">
					<div class="panel-header fg-white non-profit">
						Non-Profit<span id="np-count"></span>
					</div>
					<div class="panel-content" style="display: none;">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
					</div>
				</div>
			</div>
			<div class="span3">
      			<div class="panel" data-role="panel">
					<div class="panel-header fg-white individuals">
						Individuals<span id="ind-count"></span>
					</div>
					<div class="panel-content" style="display: none;">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
					</div>
				</div>
			</div>
			<div class="span3">
      			<div class="panel" data-role="panel">
					<div class="panel-header fg-white government">
						Government<span id="gov-count"></span>
					</div>
					<div class="panel-content" style="display: none;">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
					</div>
				</div>
			</div>
		</div>
      </div>
   </body>
</html>
