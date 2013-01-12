var fs = require('fs');
var http = require('http'),
	feedparser = require('feedparser'),
	url = 'http://feeds.feedburner.com/thechangelog',
	articles = [];



feedparser.parseUrl(url)
  .on('article', function(article){
	articles.push(article);
  });

fs.writeFile("github.json", JSON.stringify(articles), function(err) {
    if(err) {
        console.log(err);
    } else {
        console.log("The file was saved!");
    }
});


http.createServer( function(req, res) {

	res.writeHead(200, {'Content-Type': 'application/json'});
	var output = JSON.stringify(articles);
	res.end(output);

}).listen(1337, '127.0.0.1');

console.log('Server running on 127.0.0.1:1337');