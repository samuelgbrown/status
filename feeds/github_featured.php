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

$xml = simplexml_load_string(getUrl('http://feeds.feedburner.com/thechangelog?format=xml'));

print_r($xml->channel->item);