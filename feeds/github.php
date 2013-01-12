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
function getAuthUrl($url)
{

    $ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "@status bot v0.1");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_USERPWD, "NotBugger:IceCream77");
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

$t =0;
foreach ($trending_repositories as $value) {
	if($t < 5){

		$repo = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(1)->nodeValue));

		$trending_repos[$repo]['title'] = $repo;

		$trending_repos[$repo]['author'] = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(0)->nodeValue));

		$trending_repos[$repo]['description'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//p[@class="description"]', $value)->item(0)->nodeValue));

		$trending_repos[$repo]['watchers'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="watchers"]/a', $value)->item(0)->nodeValue));

		$trending_repos[$repo]['forks'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="forks"]/a', $value)->item(0)->nodeValue));
	}
	$t++;

}

foreach ($featured_repositories as $value) {

	$repo = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(1)->nodeValue));

	$featured_repos[$repo]['title'] = $repo;

	$featured_repos[$repo]['author'] = trim(preg_replace( '/\s+/', ' ',$xpath->query('.//h3/a', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['description'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//p[@class="description"]', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['watchers'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="watchers"]/a', $value)->item(0)->nodeValue));

	$featured_repos[$repo]['forks'] = trim(preg_replace( '/\s+/', ' ', $xpath->query('.//li[@class="forks"]/a', $value)->item(0)->nodeValue));
}
$languages_raw = array();

foreach ($featured_repos as $key => $value) {

	$languages_raw[] = json_decode(getAuthUrl('https://api.github.com/repos/'.$value['author'].'/'.$value['title'].'/languages'));
}
foreach ($trending_repos as $key => $value) {

	$languages_raw[] = json_decode(getAuthUrl('https://api.github.com/repos/'.$value['author'].'/'.$value['title'].'/languages'));
}

foreach ($languages_raw as $value) {
	$languages[] = get_object_vars($value);
}
$total = 0;

foreach ($languages as $key => $value) {
	foreach ($value as $name => $numbers) {
		$languages_data[$name] = $languages_data[$name] + $numbers;
		$total = $total + $numbers;
	}
}

foreach ($languages_data as $key => $value) {
	$languages_output[$key] = (($value / $total) * 100);
	
	$languages_output[$key] = (($value / $total) * 100);
}

arsort($languages_output);

$output['featured_repos']=$featured_repos;
$output['trending_repos']=$trending_repos;
$output['languages_data']=$languages_output;

print_r(json_encode($output));
