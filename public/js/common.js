var http_request;
var response;
var XMLHttpFactories = [
    function () {return new XMLHttpRequest()},
    function () {return new ActiveXObject("Msxml2.XMLHTTP")},
    function () {return new ActiveXObject("Msxml3.XMLHTTP")},
    function () {return new ActiveXObject("Microsoft.XMLHTTP")}
];

function createXMLHTTPObject() {
    var xmlhttp = false;
    for (var i=0;i<XMLHttpFactories.length;i++) {
        try {
            xmlhttp = XMLHttpFactories[i]();
        }
        catch (e) {
            continue;
        }
        break;
    }
    return xmlhttp;
}

function request( method, processor, value, url )
{
    http_request = createXMLHTTPObject();
    http_request.open( method, url + '&obj=' + value );
    http_request.send( '' );
    http_request.onreadystatechange = function()
    {
        if ( http_request.readyState == 4 )
        {
            response = http_request.responseText;
            processor( response, value );
        }
    }
}

function popWindow( url, target, width, height )
{
    if ( target == undefined )
    {
    	target = '_self';
    }
    if ( width == undefined )
    {
        width = 1024;
    }
    if ( height == undefined )
    {
    	height = 768;
    }
    var WINDOW=window.open(url, target, 'scrollbars=yes,toolbar=no,menubar=no,directories=no,location=no,status=no,resizable=no,copyhistory=no,width='+width+',height='+height+',top=0,left=0');
}