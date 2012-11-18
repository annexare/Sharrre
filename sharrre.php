<?php

/**
 * Sharrre.
 * Mod by Annexare Studio.
 *
 * @author Julien Hany
 * @todo [sharrre.php] Check Referrer.
 */

header('content-type: application/json');

$json = array('url' => '', 'count' => 0);
$json['url'] = $_GET['url'];
$url = urlencode($_GET['url']);
$type = urlencode($_GET['type']);

if (filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
	if ($type == 'googlePlus') {
		//source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
		$content = parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=" . $url . "&count=true");

		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		@$dom->loadHTML($content);
		$domxpath = new DOMXPath($dom);
		$newDom = new DOMDocument;
		$newDom->formatOutput = TRUE;

		$filtered = $domxpath->query("//div[@id='aggregateCount']");
		if (isset($filtered->item(0)->nodeValue)) {
			$json['count'] = str_replace('>', '', $filtered->item(0)->nodeValue);
		}
	} elseif ($type == 'stumbleupon') {
		$content = parse("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");

		$result = json_decode($content);
		if (isset($result->result->views)) {
			$json['count'] = $result->result->views;
			if (!$json['count'])
				$json['count'] = 0;
		}
	} elseif ($type == 'pinterest') {
		$content = parse("http://api.pinterest.com/v1/urls/count.json?callback=&url=$url");

		$result = json_decode(str_replace(array('(', ')'), array('', ''), $content));
		if (is_int($result->count)) {
			$json['count'] = $result->count;
			if (!$json['count'] || $json['count'] === '-')
				$json['count'] = 0;
		}
	} elseif ($type == 'vk') {
		// current one: shares count
		/*$content = parse("http://vk.com/share.php?act=count&url=$url");
		$s = 'VK.Share.count(0, ';

		$json['count'] = 0;

		if (($sp = strpos($content, $s)) !== FALSE) {
			$json['count'] = (int)substr($content, $sp + strlen($s), strpos($content, ')', $sp + strlen($s)));
		}*/

		// likes count, really requires App ID
		$app = (int)$_GET['app'];
		$api = "https://api.vk.com/method/likes.getList?type=sitepage&owner_id=$app&page_url=$url";
		$json['api'] = $api;
		$json['debug'] = $content = json_decode(file_get_contents($api));
		$json['count'] = $content->response->count;
	}
}

echo str_replace('\\/', '/', json_encode($json));

function parse($encUrl) {
	$options = array(
		CURLOPT_RETURNTRANSFER => TRUE,	// return web page
		CURLOPT_HEADER         => FALSE,	// don't return headers
		CURLOPT_FOLLOWLOCATION => TRUE,	// follow redirects
		CURLOPT_ENCODING       => '',	// handle all encodings
		CURLOPT_USERAGENT      => 'sharrre', // who am i
		CURLOPT_AUTOREFERER    => TRUE,	// set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 5,	// timeout on connect
		CURLOPT_TIMEOUT        => 10,	// timeout on response
		CURLOPT_MAXREDIRS      => 3,	// stop after 10 redirects
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => FALSE,
	);
	$ch = curl_init();

	$options[CURLOPT_URL] = $encUrl;
	curl_setopt_array($ch, $options);

	$content = curl_exec($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);

	curl_close($ch);

	if ($errmsg != '' || $err != '') {
		/* print_r($errmsg);
		  print_r($errmsg); */
	}
	return $content;
}
