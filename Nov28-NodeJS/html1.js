var http = require('http');

var newVisitor = function(req, res){
    res.write("Hello World");
    res.end();
}

var server = http.createServer(newVisitor);
server.listen(8080);