var convertedString = "";


//This event is called when the DOM is fully loaded
$(document).ready(function() {
{
	//Creating a new AJAX request that will request 'test.csv' from the current directory

	$.ajax({
		type: "GET",
    	url:"./data/athena_master.csv",
    	dataType: "text",
    	async:false,
    	success:function(data)
    	{
    		
    		csvToJSON(data);

	        //The response text is available in the 'response' variable
	        //Set the value of the textarea with the id 'csvResponse' to the response
	  
	        
	    }


	}); //Don't forget to send our request!
}
});


function csvToJSON(data)
			{
				var rows = data.split("\n");
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
				
				convertedString = JSON.stringify(storeObjs, null);
				// document.getElementById('random').innerHTML = convertedString;

				console.log("hello");

				saveToExt(convertedString);
				
			}

			 
function saveToExt(cString)
{

$.ajax(
	        {
			  type: 'POST',
			  dataType: 'json',
			  url: "saveJSON.php",//url of receiver file on server
			  asyn: false,
			  data: {'nodes': cString}, //your data
			  success: function(){
			  				// Check if successful:
			  				// alert("success");
			  		   } //callback when ajax request finishes
			});
}

