$(document).ready(function() {
    /*$.ajax({ 
	    type: 'POST',  
	    url: 'transactionHistory.php', 
	    //data: { get_param: 'value' }, 
	    dataType: 'json',
	    success: function (data) { 
	    	alert(data.length);
	        $.each(data, function(index, element) {
	        	
	        	
	        });

	        
	    },
	    error: function(){alert("Error: file not loaded");}
	});*/

    downloadUrl('transactionHistory.php', function(data) {
    	var json = data.responseText;
    	//alert(json);
    	//alert(json == 0);
    	/*if(json == "null"){
    		alert(json);
    		window.location.replace("Login.html");
    		return;
    	}*/
      if(json == 0){
        alert("You must login to check transaction history.")
        window.location.replace("Login.html");
        return;
      }
    	console.log(json);
    	json = JSON.parse(json);

    	json.forEach(element => {
       		var transactionTitle = element.BookTitle;
       		var borrowed = element.Date_Borrowed;
       		var returned = element.Date_Returned;
       		var due = element.Date_Due;

       		str = "<div class=\"card\" style=\"width: 800px;\"><div class=\"card-header\">Book Title: " + transactionTitle + "</div><ul class=\"list-group list-group-flush\"><li class=\"list-group-item\">Date borrowed: " + borrowed + "</li><li class=\"list-group-item\">Date due:" +due + "</li><li class=\"list-group-item\">Date returned: " + returned + "</li></ul></div><br/>";

       		$("#content").append(str);
        });
    	
    });
	function downloadUrl(url,callback) {
        	var request = new XMLHttpRequest;

         	request.onreadystatechange = function() {
           		if (request.readyState == 4) {
            		request.onreadystatechange = doNothing;
            		callback(request, request.status);
           		}
         	};

         	request.open('POST', url, true);
         	request.send(null);
        }

        function doNothing() {}
});


//[{"Id":"123450","BookId":"16","UserId":"9876","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123451","BookId":"8","UserId":"5213","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123452","BookId":"6","UserId":"7545","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123456","BookId":"12","UserId":"9876","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123457","BookId":"10","UserId":"9658","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123458","BookId":"14","UserId":"5251","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"},{"Id":"123459","BookId":"1","UserId":"9876","Date_Borrowed":"2020-12-03","Date_Returned":"2020-12-14","Date_Due":"2020-12-17"}]