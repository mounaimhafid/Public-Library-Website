var path;
var title;
var numCopies;
var borrowed;
var returnOn;
var name;
var dataCopy;
$(document).ready(function() {
    

	downloadUrl('cart.php', function(data) {
    	var json = data.responseText;
    	//alert(json);
    	if(json == "login"){
    		alert("You must login before accessing your checkout cart");
    		window.location.replace("Login.html");
    		return;
    	}
    	else
    	{
    		name = json;
		    $.ajax({ 
			    //type: 'GET', 
			    url: 'json/shoppingCart.json', 
			    //data: { get_param: 'value' }, 
			    dataType: 'json',
			    success: function (data) {
			    	dataCopy = data; 
			        $.each(data, function(index, element) {
			        	
			        	path = element.imgSrc;
			        	title = element.bookTitle;
			        	numCopies = element.numCopies;
			        	borrowed = element.dateBorrowed;
			        	returnOn = element.dateDue;
			        	
			        	var structure = 
			        	"<div class=\"card\" style=\"width: 18rem;\"><img class=\"card-img-top\" src=\"" + path + "\" alt=\"Book Image\"><div class=\"card-body\"><h5 class=\"card-title\">" + title + "</h5></div><ul class=\"list-group list-group-flush\"><li class=\"list-group-item\">Number of Copies: " + numCopies + "</li><li class=\"list-group-item\">Date borrowed: " + borrowed + "</li><li class=\"list-group-item\">Due Date: " + returnOn + "</li></ul><div class=\"card-body\"><form action = \"deleteCart.php\" method = \"GET\"><button name = \"deleteItem\" value = \"" + title + "\" type = \"submit\" class = \"btn btn-danger\"> Delete </button></form></div></div><br/>";

			            $('#cartItems').append(structure);
			        });

			        if(data.length > 0){
			        	var button = "<button id = \"checkoutButton\" type=\"button\" class=\"btn btn-success\">Checkout</button>"
			        	$("#midcol").append(button);

			        	$('#checkoutButton').click(function(){

			        		$.each(dataCopy, function(index, element) {
			        			//alert(dataCopy);
			        			var rnum = generateRandomNum();
			        			var info = [rnum, element.bookTitle, element.dateBorrowed, element.dateDue, name];
			        			//alert(info);
			        			sendURL(info);
			        			//await sleep(5000);
			        		});

			        		
							//alert(window.location.pathname);
							window.location.replace("transaction.html");
						});
			        }
			    },
			    error: function(){alert("Error: file not loaded");}
			});

    	}
    });



	function sleep(ms) 
	{
  		return new Promise(resolve => setTimeout(resolve, ms));
	}

    	
    function generateRandomNum(min = 100000, max = 999999)
    {
  		return Math.floor(Math.random() * (max - min + 1) ) + min;
	}

	function downloadUrl(url,callback) 
	{
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

    function sendURL(info) 
	{
        	var request = new XMLHttpRequest;

         	request.onreadystatechange = function() {
           		if (request.readyState == 4) {
            		request.onreadystatechange = doNothing;
            		callback(request, request.status);
           		}
         	};
         	var str = "addToTransaction.php?r="+info[0]+"&title=" + info[1] + "&borrow="+info[2]+"&return="+info[3]+"&name=" +info[4];

         	request.open('GET', str , true);
         	request.send();
    }

    function doNothing() {}

	
});