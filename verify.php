<?php
$access_token = 'ynA5MCG/ofxR7Pi1KKef38pKzcAs9QBmHYfKhXiKJ6ZUH5VMcFg0j5G44JTWlu9FCRIjH51WbEOTIVVWvyq+bbQc0/gxyu3ikfWBGkKSJrn80CzDCHQAmL33q9WWMKBht2IxcsOAwBIyTg6Yl20kAAdB04t89/1O/w1cDnyilFU=';
$proxy = 'http://fixie:Ab98JkLVuPQiz4J@velodrome.usefixie.com:80';
$proxyauth = 'mrdark6996@gmail.com:Nui14042525';
$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;