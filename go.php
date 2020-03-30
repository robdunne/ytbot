<?php
/*
*	Increase YouTube Views
*	Usage: php go.php
*/

// Don't timeout
set_time_limit(0);

// Set vars
$n = 0;
$video = '8Ph6xYggAlc';
$apikey = 'YOUR MASHAPE.COM API KEY';

// Loop forever until you decide to stop
for(;;) {
	// Get the list of proxies
	$ch = curl_init("https://proxylist.p.mashape.com/get");
	$header = array(
		'Accept: application/json',
		'X-Mashape-Authorization: '.$apikey
		);

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$json = curl_exec($ch);
	curl_close($ch);

	$proxies = json_decode($json,true);

	for($i=0;$i<count($proxies['data']);$i++) {
		// Get the views
		$url = "http://www.youtube.com/watch?v=".$video;
		$proxy = $proxies['data'][$i]['PROXY_IP'];
		$port = $proxies['data'][$i]['PROXY_PORT'];
		$country = $proxies['data'][$i]['PROXY_COUNTRY'];
		$type = $proxies['data'][$i]['PROXY_TYPE'];
		$useragent = array(
			"Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
			"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36",
			"Mozilla/5.0 (X11; Linux x86_64; rv:6.0.1) Gecko/20110831 conkeror/0.9.3",
			"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)",
			"Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; Media Center PC 4.0; SLCC1; .NET CLR 3.0.04320)",
			"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 3.0)"
			);
	
		echo PHP_EOL.'Using '.$type.' proxy '.$proxy.':'.$port.' in '.$country.'...';
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_PROXYPORT, $port);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent[rand(0,count($useragent))]);
		$result = curl_exec($ch);
		curl_close($ch);
	
		$r = ($result !== FALSE) ? 'Got it... '.substr($result,0,50) : 'nothing returned';
		echo $r;
	}
}
