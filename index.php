<?php
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

// PRICE_DATE , PRODUCT ,PRICE
foreach ($xml  as  $key =>$val) {  
$text = "";
if($val->PRICE != ''){
$text .=  'kk' . $val->PRODUCT .'  '.$val->PRICE.' บาท<br>';
}

echo $text;
}