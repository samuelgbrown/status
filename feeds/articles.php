<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 0);

$page = ($_GET['page'])?$_GET['page']:1;
$limit = 10;
$startPos = $limit * ($page-1);

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

function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    arsort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}


$bbc_articles_raw = simplexml_load_string(getUrl('http://feeds.bbci.co.uk/news/technology/rss.xml'));

$hn_articles = json_decode(getUrl('http://api.ihackernews.com/page?format=json'));

$reddit_programming = json_decode(getUrl('http://www.reddit.com/r/programming.json'));

$reddit_android = json_decode(getUrl('http://www.reddit.com/r/android.json'));

$reddit_netsec = json_decode(getUrl('http://www.reddit.com/r/netsec.json'));

$reddit_javascript = json_decode(getUrl('http://www.reddit.com/r/javascript.json'));

$articles = null;

foreach ($hn_articles->items as $article) {
	$articles[md5($article->url)]['title'] = $article->title;
	$articles[md5($article->url)]['url'] = $article->url;
	$articles[md5($article->url)]['sources']["hacker_news"]['title'] = $article->title;
	$articles[md5($article->url)]['sources']["hacker_news"]['points'] = $article->points;
	$articles[md5($article->url)]['rank'] = $article->points;

}

foreach ($bbc_articles_raw->channel->item as $bbc_article) {
	$link = str_replace("#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa", "", $bbc_article->link);
	if(!$articles[md5($link)])
	{
		$articles[md5($link)]['title'] = $bbc_article->title;
		$articles[md5($link)]['url'] = $link;
	}
	$articles[md5($link)]['sources']["bbc_news"]['title'] = $bbc_article->title;
	$articles[md5($link)]['sources']["bbc_news"]['description'] = $bbc_article->description;
	$shares = json_decode(getUrl('http://open.bbci.co.uk/buzz/shares?url='.$link));
	if($shares->facebook && $shares->twitter)
	{
		$share_count  = ($shares->facebook + $shares->twitter);
	}
	else
	{
		$share_count = 0;
	}
	$articles[md5($link)]['sources']["bbc_news"]['shares'] = $share_count;
	$articles[md5($link)]['rank'] = $share_count;
	$link = $shares = $share_count = null;
}

foreach ($reddit_programming->data->children as $article) {
	if(!$articles[md5($article->data->url)]){
		$articles[md5($article->data->url)]['title'] = $article->data->title;
		$articles[md5($article->data->url)]['url'] = $article->data->url;
	}
	$articles[md5($article->data->url)]['sources']["reddit"]['title'] = $article->data->title;
	$articles[md5($article->data->url)]['sources']["reddit"]['up_votes'] = $article->data->ups;
	$articles[md5($article->data->url)]['sources']["reddit"]['subreddit'] = "programming";
	$articles[md5($article->data->url)]['rank'] = $articles[md5($article->data->url)]['sources']['rank'] + $article->data->ups;

}

foreach ($reddit_netsec->data->children as $article) {
	if(!$articles[md5($article->data->url)]){
		$articles[md5($article->data->url)]['title'] = $article->data->title;
		$articles[md5($article->data->url)]['url'] = $article->data->url;
	}
	$articles[md5($article->data->url)]['sources']["reddit"]['title'] = $article->data->title;
	$articles[md5($article->data->url)]['sources']["reddit"]['up_votes'] = $article->data->ups;
	$articles[md5($article->data->url)]['sources']["reddit"]['subreddit'] = "netsec";
	$articles[md5($article->data->url)]['rank'] = $articles[md5($article->data->url)]['sources']['rank'] + $article->data->ups;

}

foreach ($reddit_android->data->children as $article) {
	if(!$articles[md5($article->data->url)]){
		$articles[md5($article->data->url)]['title'] = $article->data->title;
		$articles[md5($article->data->url)]['url'] = $article->data->url;
	}
	$articles[md5($article->data->url)]['sources']["reddit"]['title'] = $article->data->title;
	$articles[md5($article->data->url)]['sources']["reddit"]['up_votes'] = $article->data->ups;
	$articles[md5($article->data->url)]['sources']["reddit"]['subreddit'] = "android";
	$articles[md5($article->data->url)]['rank'] = $articles[md5($article->data->url)]['sources']['rank'] + $article->data->ups;

}

foreach ($reddit_javascript->data->children as $article) {
	if(!$articles[md5($article->data->url)]){
		$articles[md5($article->data->url)]['title'] = $article->data->title;
		$articles[md5($article->data->url)]['url'] = $article->data->url;
	}
	$articles[md5($article->data->url)]['sources']["reddit"]['title'] = $article->data->title;
	$articles[md5($article->data->url)]['sources']["reddit"]['up_votes'] = $article->data->ups;
	$articles[md5($article->data->url)]['sources']["reddit"]['subreddit'] = "javascript";
	$articles[md5($article->data->url)]['rank'] = $articles[md5($article->data->url)]['sources']['rank'] + $article->data->ups;

}

aasort($articles,"rank");

$stories['stories']=$articles;

print_r(json_encode($stories));