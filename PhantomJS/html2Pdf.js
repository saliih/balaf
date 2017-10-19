// html2pdf.js
var page = new WebPage();
var system = require("system");
var fs = require('fs');
var url = "";
var header_height = 1.5;
var margin_right = margin_top = 0;
var header_file = "";
var footer_content = "";
var orientation = "portrait";
var result = "";
var window_status = 0;
var timeout =  60000;// 1 minute
var export_image = false;
var image_width = 1000;
var image_height = 50; //image height will be determined automatically according to content
var help_content = "Global View html2pdf converter\n" +
    "-page_url :    url de la page a convertir\n" +
    "-page_header : path to file header\n" +
    "-page_footer : path to file footer\n" +
    " exit\n";
console.log("Process started!");
if (system.args.length === 1) {
    console.log('Try to pass some args when invoking this script!');
} else {

    for (var i = 1; i <= system.args.length; i++) {
        var current_arg = system.args[i];
        if (current_arg == "-page_url") {
            url = system.args[i + 1];
            i++;
        }
        if (current_arg == "-page_header") {
            header_file = system.args[i + 1].replace(/\\/g, '/');
            i++;
        }
        if (current_arg == "-page_footer") {
            footer_file = system.args[i + 1].replace(/\\/g, '/');
            footer_content = fs.read(footer_file);
            i++;
        }
        if (current_arg == "-footer_content") {
            footer_content = system.args[i + 1];
            i++;
        }
        if (current_arg == "-help") {
            console.log(help_content);
            phantom.exit();
        }
        if (current_arg == "-orientation") {
            orientation = system.args[i + 1];
        }
        if (current_arg == "-result") {
            result = system.args[i + 1];
        }
        if (current_arg == "-window_status") {
            window_status = system.args[i + 1];
        }
        if (current_arg == "-header_height") {
            header_height = system.args[i + 1];
        }
        if (current_arg == "-margin_top") {
            margin_top = system.args[i + 1];
        }
        if (current_arg == "-margin_right") {
            margin_right = system.args[i + 1];
        }
        if(current_arg == "-timeout")
        {
            timeout = system.args[i+1];
        }
        if (current_arg == "-export_image") {
            export_image = true;
        }
        if (current_arg == "-image_width") {
            image_width = system.args[i + 1];
        }
        if (current_arg == "-image_height") {
            image_height = system.args[i + 1];
        }
    }
}

function waitFor(testFx, onReady, timeOutMillis) {
    var maxtimeOutMillis = timeOutMillis ? timeOutMillis : timeout, //< Default Max Timout is 40s
        start = new Date().getTime(),
        condition = false,
        interval = setInterval(function () {
            if ((new Date().getTime() - start < maxtimeOutMillis) && !condition) {
                // If not time-out yet and condition not yet fulfilled
                condition = (typeof(testFx) === "string" ? eval(testFx) : testFx()); //< defensive code
            } else {
                if (!condition) {
                    // If condition still not fulfilled (timeout but condition is 'false')
                    console.log("'waitFor()' timeout");
                    phantom.exit(1);
                } else {
                    // Condition fulfilled (timeout and/or condition is 'true')
                    console.log("Page loaded in " + (new Date().getTime() - start) + "ms.");
                    typeof(onReady) === "string" ? eval(onReady) : onReady(); //< Do what it's supposed to do once the condition is fulfilled
                    clearInterval(interval); //< Stop this interval
                }
            }
        }, 250); //< repeat check every 250ms
}

try {
    page.onConsoleMessage = function(msg) {
        console.log('CONSOLE: ' + msg);
    };
    page.settings.resourceTimeout = timeout;
    page.onResourceTimeout = function(e) {
        console.log(e.errorCode);   // it'll probably be 408
        console.log(e.errorString); // it'll probably be 'Network timeout on resource'
        console.log(e.url);         // the url whose request timed out
        phantom.exit(1);
    };
    page.onError = function(msg, trace) {

        var msgStack = ['ERROR: ' + msg];

        if (trace && trace.length) {
            msgStack.push('TRACE:');
            trace.forEach(function(t) {
                msgStack.push(' -> ' + t.file + ': ' + t.line + (t.function ? ' (in function "' + t.function +'")' : ''));
            });
        }

        console.error(msgStack.join('\n'));
    };
    if (export_image) {
        page.viewportSize = {width: image_width, height: image_height};
    }
    page.open(url, function (status) {

        // Check for page load success
        if (status !== "success") {
            console.log("Error opening url : " + status);
            phantom.exit();
        } else {

            waitFor(function () {
                var debug = page.evaluate(function () {
                    return (window._finishedCall == undefined) || (window._finishedCall <= 0);
                });
                console.log(debug);
                return debug;
            }, function () {
                console.log("The page load is complete.");
                if (!export_image) {
                    if (orientation == "raw") {
                        var width = page.evaluate(function () {
                            return document.body.offsetWidth;
                        });
                        var height = page.evaluate(function () {
                            return document.body.offsetHeight;
                        });
                        page.paperSize = {
                            //format: 'A4',
                            //orientation: orientation,
                            margin: {right: margin_right + "px", top: margin_top + "cm", bottom: margin_top + "cm"},
                            height: height * 1.155,
                            width: width,
                            footer: {
                                height: "0.9cm",
                                contents: phantom.callback(function (pageNum, numPages) {
                                    if (footer_content != "") {
                                        return footer_content.replace('<span class=\'page\'></span>', pageNum).replace("frompage", pageNum).replace("<span class=\'topage\'></span>", "&nbsp;" + numPages).replace("topagenum", "&nbsp;" + numPages);
                                    }
                                    return "";
                                })
                            },
                            header: {
                                height: header_height + "cm",
                                contents: phantom.callback(function (pageNum, numPages) {
                                    if (header_file != "") {
                                        return fs.read(header_file).replace('<span class=\'page\'></span>', pageNum).replace("<span class=\'topage\'></span>", "&nbsp;" + numPages);
                                    }
                                    return "";
                                })
                            }
                        };
                    } else {
                        page.paperSize = {
                            format: 'A4',
                            orientation: orientation,
                            margin: {right: margin_right + "px", top: margin_top + "cm", bottom: margin_top + "cm"},
                            footer: {
                                height: "0.9cm",
                                contents: phantom.callback(function (pageNum, numPages) {
                                    if (footer_content != "") {
                                        return footer_content.replace('<span class=\'page\'></span>', pageNum).replace("frompage", pageNum).replace("<span class=\'topage\'></span>", "&nbsp;" + numPages).replace("topagenum", "&nbsp;" + numPages);
                                    }
                                    return "";
                                })
                            },
                            header: {
                                height: header_height + "cm",
                                contents: phantom.callback(function (pageNum, numPages) {
                                    if (header_file != "") {
                                        //console.log(fs.read(header_file));
                                        return fs.read(header_file).replace('<span class=\'page\'></span>', pageNum).replace("<span class=\'topage\'></span>", "&nbsp;" + numPages);
                                    }
                                    return "";
                                })
                            }
                        };
                    }
                }

                var options = export_image ? {format: "png"} : {};
                page.render(result, options);
                phantom.exit();
            });
        }
    });
} catch (e) {
    console.log("Error occured: exitting!");
    phantom.exit();
}