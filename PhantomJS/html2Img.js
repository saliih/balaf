// html2pdf.js
var page = new WebPage();
var system = require("system");
var fs = require('fs');
var url = "";
var result = "";
var window_status = 0;
var help_content = "html2img convert\n"+
                   "-page_url :    url de la page a convertir\n"+
				   " exit\n";
console.log("Process started!");
if (system.args.length === 1) {
    console.log('Try to pass some args when invoking this script!');
} else {
    
	for(var i = 1;i<= system.args.length;i++)
	{
		var current_arg = system.args[i];
		if(current_arg == "-page_url")
		{
			url = system.args[i+1];
			i++;
		}
		if(current_arg == "-help")
		{
			console.log(help_content);
			phantom.exit();
		}
		if(current_arg == "-result")
		{
			result = system.args[i+1];
		}
		if (current_arg == "-window_status")
		{
			window_status = system.args[i+1];
		}
	}
}
page.viewportSize = {width: 1000, height: 500};
console.log("Here 0!");
function waitFor(testFx, onReady, timeOutMillis) {
		var maxtimeOutMillis = timeOutMillis ? timeOutMillis : 400000, //< Default Max Timout is 400s
		start = new Date().getTime(),
		condition = false,
		interval = setInterval(function() {
			if ( (new Date().getTime() - start < maxtimeOutMillis) && !condition ) {
			// If not time-out yet and condition not yet fulfilled
			condition = (typeof(testFx) === "string" ? eval(testFx) : testFx()); //< defensive code
			} else {
				if(!condition) {
				// If condition still not fulfilled (timeout but condition is 'false')
				console.log("'waitFor()' timeout");
				phantom.exit(1);
				} else {
				// Condition fulfilled (timeout and/or condition is 'true')
				//console.log("[ "+getDateTime()+" ] End convertion.\n");
				console.log("Page loaded in " + (new Date().getTime() - start) + "ms.");
				typeof(onReady) === "string" ? eval(onReady) : onReady(); //< Do what it's supposed to do once the condition is fulfilled
				clearInterval(interval); //< Stop this interval
				}
			}
		}, 250); //< repeat check every 250ms
};

try {
	console.log("Here 1!");
	page.open(url, function (status) {
		// Check for page load success
		console.log("Here 2!");
		if (status !== "success") {
			console.log("Unable to access network");
		} else {
			// Wait for 'signin-dropdown' to be visible
			waitFor(function() {
				// Check in the page if a specific element is now visible
				var nb_dy = page.evaluate(function() {
					var nb_dynamic = document.getElementById('nb_dynamic');
					if (nb_dynamic)
						return nb_dynamic.value;
					else
						return -1;
				});
				console.log(nb_dy +'=='+window_status);
				return (nb_dy == window_status) || (nb_dy == -1);
			}, function() {
				console.log("The page load is complete.");
				page.render(result, {
				  format: "jpeg",
				  quality: '95'
				});
				phantom.exit();
			});
		}
	});
} catch (e) {
	console.log("Error occured: exitting!");
	phantom.exit();
}