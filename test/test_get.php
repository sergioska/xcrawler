<?php

require_once('vendor/autoload.php');
define ('XSL_TEST', 'stylesheets/advs-get.xsl');

use xcrawler\Bot;
use xcrawler\Processor\Factory;


$oBot = new Bot();

$oBot->setUrl("http://www.example.com/advs/");
$sPage = "";

if(!file_exists('buffer.bak')){
	$sPage = $oBot->get();
	file_put_contents('buffer.bak', $sPage);
}else{
	$sPage = file_get_contents('buffer.bak');
}

$oProcessor = Processor::factory($sPage, XSL_TEST);
$sXml = $oProcessor->process($sPage, XSL_TEST);

echo $sXml;

$oBot->close();
