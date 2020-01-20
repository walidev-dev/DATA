<?php
require 'vendor/autoload.php';

$client = new SoapClient("http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx?wsdl");

$soapResponse = $client->__soapCall('getListOfCurrencies', []);
//$array = json_decode(json_encode($soapResponse), true);
//$xmlstring = $array['getListOfCurrenciesResult']['any'];
$xmlString = $soapResponse->getListOfCurrenciesResult->any;

$xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json, true);
foreach ($array['item'] as $item) {
    dump($item);
}


