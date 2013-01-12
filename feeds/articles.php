<?php
 error_reporting(E_WARNINGS);
 ini_set("display_errors", 1);


header('Content-type: application/json');

function getUrl($url)
{

    $ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "@status bot v0.1");
	return curl_exec($ch);
	curl_close($ch);
	$ch = null;
}

$hn_articles = json_decode(getUrl('http://api.ihackernews.com/page?format=json'));

$reddit_programming = json_decode(getUrl('http://www.reddit.com/r/programming.json'));
/*
$reddit_android = json_decode(getUrl('http://www.reddit.com/r/android.json'));

$reddit_netsec = json_decode(getUrl('http://www.reddit.com/r/netsec.json'));

$reddit_javascript = json_decode(getUrl('http://www.reddit.com/r/javascript.json'));*/

//print_r($reddit_programming->data->children);

$articles = null;

foreach ($hn_articles->items as $article) {
	$articles[md5($article->url)]['title'] = $article->title;	
	$articles[md5($article->url)]['url'] = $article->url;
	$articles[md5($article->url)]['sources']["hacker_news"]['title'] = $article->title;
	$articles[md5($article->url)]['sources']["hacker_news"]['points'] = $article->points;

}

foreach ($reddit_programming->data->children as $article) {
	if($articles[md5($article->data->url)]){
		$articles[md5($article->data->url)]['title'] = $article->data->title;	
		$articles[md5($article->data->url)]['link'] = $article->data->url;
	}
	$articles[md5($article->data->url)]['sources']["reddit_programming"]['title'] = $article->data->title;	
	$articles[md5($article->data->url)]['sources']["reddit_programming"]['up_votes'] = $article->data->ups;

}

print_r(json_encode($articles));