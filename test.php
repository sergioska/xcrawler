<?php

require_once('conf/autoload.php');
spl_autoload_register(array('ClassLoader', 'autoloader'));

define ('XSL_TEST', 'stylesheets/yahoorss.xsl');

$oBot = new Bot();

$oBot->setUrl("http://it.notizie.yahoo.com/rss/");
$sPage = $oBot->get();

$oProcessor = Processor_Factory::factory($sPage, XSL_TEST);
$sXml = $oProcessor->process($sPage, XSL_TEST);

echo $sXml;

$oBot->close();