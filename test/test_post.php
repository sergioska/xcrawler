<?php

require_once('vendor/autoload.php');
define ('XSL_TEST', 'stylesheets/advs-post.xsl');

use xcrawler\Bot;
use xcrawler\Processor\Factory;

$aParams = array("email" => "xxx@xxx.com", "password" => "1234567890", "mode" => "xml", "persistent" => 1);

$oBot = new Bot();
$oBot->setUrl("http://www.example.com");
$oBot->login($aParams);

$oBot->setUrl("http://www.example.com/bookmarkadvs.php");
$sPage = $oBot->get();

$oProcessor = Processor::factory($sPage, XSL_TEST);
$sXml = $oProcessor->process($sPage, XSL_TEST);

echo $sXml;

$oBot->close();
