var http = require('http');
var url = require('url');
var querystring = require('querystring');


var newVisitor = function(req, res){
    res.writeHead(200, {"Content-Type": "text/html"});
    
    var pageRequest = url.parse(req.url).pathname;
    var params = querystring.parse(url.parse(req.url).query);
    
    res.write("<h1>Enter 2 numbers to multiply:</h1>");
    res.write("<p><form method='get'>");
    res.write("<input name='a' type='text'>");
    res.write("<input name='b' type='text'>");
    res.write("<input type='submit' value='Multiply!'>");
    if( 'a' in params && 'b' in params){
        res.write((params['a'] * params['b']).toString());
    }
    
    res.end();
}

var server = http.createServer(newVisitor);
server.listen(8080);