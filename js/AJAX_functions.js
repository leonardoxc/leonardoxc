/******************************************
    Generic AJAX
___________________________________________*/

function getAjax(url, vars, callbackFunction){
	//  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MSXML2.XMLHTTP.3.0");
	// var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");	  
	
	if (window.XMLHttpRequest) {
		// browser has native support for XMLHttpRequest object
		var request= new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		// try XMLHTTP ActiveX (Internet Explorer) version
		var request = new ActiveXObject("Microsoft.XMLHTTP");
		// alert("ie");
	} else   {
	 alert('Your browser does not seem to support XMLHttpRequest.');
	}

	// alert(url);
	request.open("GET", url, true);
	request.onreadystatechange = function(){
		if (request.readyState == 4 || request.readyState=='complete') {
			if (request.status == 200) {
				//  alert("OK  URL.");
				callbackFunction(request.responseText);
				//the_object = eval("(" + http_request.responseText + ")");
			} else {
				alert("There was a problem with the URL "+url);
			}
			request = null;
		}
	};
	// i have moved this below see
	// http://keelypavan.blogspot.com/2006/03/reusing-xmlhttprequest-object-in-ie.html
	// http://blog.davber.com/2006/08/22/ajax-and-ie-caching-problems/
	request.setRequestHeader("content-type","application/x-www-form-urlencoded");
	request.send(vars);
}

