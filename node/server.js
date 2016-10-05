/**
 * Created by Richard on 2016/8/1.
 */
var http = require('http');
var querystring = require("querystring");
var libdot = require("graphlib-dot");
var graphlib = require("graphlib");
http.createServer((req, res) => {
    var _POST = '';
    req.addListener('data', chunk => {
        if (chunk !== undefined) {
            _POST += chunk.toString();
        }
        console.log("chunk  " + chunk + "\n");
    })
       .addListener('end', function () {
           dot = JSON.parse(_POST)['dot'];
           res.writeHead(200, {'Content-Type': 'text/plain'});
           var json = JSON.stringify(graphlib.json.write(libdot.read(dot)));
           res.end(json);
       });
}).listen(8000, '0.0.0.0');


console.log('Server running at http://0.0.0.0:8000/');
