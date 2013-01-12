var http = require('http'),
	feedparser = require('feedparser'),
	url = 'http://api.ihackernews.com/page?format=json',
	articles = [];
