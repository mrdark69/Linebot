<?php
$access_token = 'ynA5MCG/ofxR7Pi1KKef38pKzcAs9QBmHYfKhXiKJ6ZUH5VMcFg0j5G44JTWlu9FCRIjH51WbEOTIVVWvyq+bbQc0/gxyu3ikfWBGkKSJrn80CzDCHQAmL33q9WWMKBht2IxcsOAwBIyTg6Yl20kAAdB04t89/1O/w1cDnyilFU=';


$proxy = 'http://fixie:Ab98JkLVuPQiz4J@velodrome.usefixie.com:80';
$proxyauth = 'mrdark6996@gmail.com:Nui14042525';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];


			if($text == 'ราคาน้ำมัน'){

				$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL",
		    	array(
			           "trace"      => 1,		// enable trace to view what is happening
			           "exceptions" => 0,		// disable exceptions
			          "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
		           );

               $params = array(
                   'Language' => "en",
                   'DD' => date('d'),
                   'MM' => date('m'),
                   'YYYY' => date('Y')
               );

		        $data = $client->GetOilPrice($params);
              $ob = $data->GetOilPriceResult;
            $xml = new SimpleXMLElement($ob);
			$text = "";
               // PRICE_DATE , PRODUCT ,PRICE
              foreach ($xml  as  $key =>$val) {  
			
            if($val->PRICE != ''){
				$text .=  $val->PRODUCT .'  '.$val->PRICE.' บาท\n';
                }

               }
				
			}

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";