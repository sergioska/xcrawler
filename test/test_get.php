<?php

require_once('vendor/autoload.php');
define ('XSL_LIST', 'stylesheets/micam.xsl');
define ('URL_LIST', "http://themicam.smart-catalog.it/it/catalogo/elenco-completo-espositori/");
define ('XSL_DETAILS', 'stylesheets/micam-details.xsl');
define ('URL_DETAILS_BASE', 'http://themicam.smart-catalog.it');
define ('BUFFER_PATH', 'buffer/');

use xcrawler\Bot;
use xcrawler\Processor\Factory;

$cMarker = "";
if (count($argv) > 1) {
	$cMarker = "-" . $argv[1];
}

$oBot = new Bot();
//var_dump(URL_LIST . str_replace("-", "", $cMarker));die("OK");
$oBot->setUrl(URL_LIST . str_replace("-", "", $cMarker));
$oBot->setProxy('192.168.99.100:9050');
$oBot->setSOCKS5();
$sPage = "";
$sPage = bufferize($oBot, BUFFER_PATH . sprintf('buffer%s.bak', $cMarker), $sPage);
$sPage = removeTags($sPage);

$oProcessor = new factory($sPage, XSL_LIST);
$sXml = $oProcessor->process($sPage, XSL_LIST);

$aXml = xmlToArray($sXml);

$oBot->close();

$i=0;
foreach($aXml['result']['item'] as $item) {
	//echo "LINK: " . $item['link'] . "\n";
	$oDetailsBot = new Bot();
	$oDetailsBot->setUrl(URL_DETAILS_BASE . $item['link']);
	$sDetailsPage = "";
	$bak = sprintf('buffer-details%s-%d.bak', $cMarker, $i);
	$sDetailsPage = bufferize($oDetailsBot, BUFFER_PATH . $bak, $sDetailsPage);
	$sDetailsPage = removeTags($sDetailsPage);
	$oDetailsProcessor = new factory($sDetailsPage, XSL_DETAILS);
	$sDetailsXml = $oProcessor->process($sDetailsPage, XSL_DETAILS);
	$aEmail = xmlToArray($sDetailsXml);
	if ($aEmail['result'])
		echo $item['name'] . ", " . $aEmail['result']['item']['email'] . "\n";
	$i++;
}


function xmlToArray($str) {
	$xml = simplexml_load_string($str, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	return $array;
}

function removeTags($sPage) {
	$sPage = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $sPage);
	$sPage = preg_replace('#<head>(.*?)</head>#is', '', $sPage);
	$sPage = str_replace("&nbsp;", "", $sPage);
	return $sPage;
}

function bufferize($oBot, $sPath, $sPage) {
	if(!file_exists($sPath)){
		$sPage = $oBot->get();
		file_put_contents($sPath, $sPage);
		sleep(1);
	}else{
		$sPage = file_get_contents($sPath);
	}
	return $sPage;
}



