<?php
 error_reporting(E_ALL);//E_WARNINGS);
 ini_set("display_errors", 1);

header('Content-type: application/json');

$doc = new DOMDocument();

function getUrl($url)
{

    $ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "@status bot v0.1");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	return curl_exec($ch);
	curl_close($ch);
	$ch = null;
}

$doc->loadHTML(getUrl('https://github.com/explore'));

$xpath = new DOMXpath($doc);

$trending_repositories = $xpath->query('//ol/li');//ol[@class="ranked-repositories"]');

$ranked_repositories = $xpath->query('//ul[@class="ranked-repositories"]');

foreach ($trending_repositories as $value) {

	$repo = $xpath->query('.//h3/a/2', $value)->item(0)->nodeValue;

	print_r($repo);

/*
	$trending_repos[$repo]['author'] = $xpath->query('.//h3/a/1', $value)->item(0)->nodeValue;

	$trending_repos[$repo]['description '] = $xpath->query('.//p[@class="description"]', $value)->item(0)->nodeValue;

	$trending_repos[$repo]['watchers'] = $xpath->query('.//li[@class="watchers"]/a', $value)->item(0)->nodeValue;

	$trending_repos[$repo]['forks'] = $xpath->query('.//li[@class="forks"]/a', $value)->item(0)->nodeValue;*/

}

foreach ($ranked_repositories as $value) {
	//print($value->nodeValue);
}

print_r($trending_repos);