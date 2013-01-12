<?php
 error_reporting(E_WARNING);
 ini_set("display_errors", 0);

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

$trending_repositories = $xpath->query('//ol/li');

$featured_repositories = $xpath->query('//ul[@class="ranked-repositories"]/li');

$trending_repos = array();
$featured_repos = array();

foreach ($featured_repositories as $value) {

	$repo = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(1)->nodeValue));

	$trending_repos[$repo]['title'] = $repo;

	$trending_repos[$repo]['author'] = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(0)->nodeValue));

	$trending_repos[$repo]['description'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//p[@class="description"]', $value)->item(0)->nodeValue));

	$trending_repos[$repo]['watchers'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="watchers"]/a', $value)->item(0)->nodeValue));

	$trending_repos[$repo]['forks'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="forks"]/a', $value)->item(0)->nodeValue));


}

foreach ($featured_repositories as $value) {

	$repo = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(1)->nodeValue));
	
	$trending_repos[$repo]['title'] = $repo;

	$featured_repos[$repo]['author'] = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['description'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//p[@class="description"]', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['watchers'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="watchers"]/a', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['forks'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="forks"]/a', $value)->item(0)->nodeValue));
}

$output['featured_repos']=$featured_repos;
$output['trending_repos']=$trending_repos;

print_r(json_encode($output));
