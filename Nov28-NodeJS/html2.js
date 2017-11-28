var http = require('http');
var url = require('url');

var counter = 0;

var newVisitor = function(req, res){
    res.writeHead(200, {"Content-Type": "text/html"});
    var pageRequest = url.parse(req.url).pathname;
    console.info(pageRequest);
    if(pageRequest == '/'){
        res.write("<h1>Hello World!</h1>");
        res.write(counter.toString());
    }else if(pageRequest == '/test'){
        res.write("<h1>testing</h1>");
    }else{
        res.write("<h1>What are you doing?!?</h1>");
    }
    counter++;
    
    res.end();
}

var server = http.createServer(newVisitor);
server.listen(8080);