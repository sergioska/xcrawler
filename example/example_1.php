<?php

require_once('vendor/autoload.php');

use xcrawler\Bot;
use xcrawler\Processor\Factory;
use xcrawler\Utils;


class Spider
{

	const XSL_LIST = 'stylesheets/list_example.xsl';
	const URL_LIST = "http://www.example.com/list.php?ltr=%s";
	const XSL_DETAILS = 'stylesheets/details_example.xsl';
	const URL_DETAILS_BASE = 'http://www.example.com';
	const BUFFER_PATH = 'buffer/';

	static public function run()
	{

		$aPages = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		for ($nPage=0; $nPage < count($aPages); $nPage++) {

			$oBot = new Bot();
			$oBot->setUrl(sprintf(self::URL_LIST, $aPages[$nPage]));
			$oBot->setProxy('192.168.99.100:9050');
			$oBot->setSOCKS5();
			$sPage = "";
			$sPage = Utils::bufferize(self::BUFFER_PATH . sprintf('buffer-%d.bak', $nPage), array('Spider', 'getData'), array($oBot));

			$oProcessor = Factory::factory($sPage, self::XSL_LIST);
			$sXml = $oProcessor->process($sPage, self::XSL_LIST);
			$aXml = Utils::xmlToArray($sXml);

			$i=0;
			foreach($aXml['result']['item'] as $item) {

				if(empty($item['name']))
					continue;
				//var_dump($item['link']);die("OK");
				$oDetailsBot = new Bot();
				$oDetailsBot->setProxy('192.168.99.100:9050');
				$oDetailsBot->setSOCKS5();
				$oDetailsBot->setUrl(self::URL_DETAILS_BASE . $item['link']);
				$sDetailsPage = "";
				$bak = sprintf('buffer-details-%d-%d.bak', $nPage, $i);
				$sDetailsPage = Utils::bufferize(self::BUFFER_PATH . $bak, array('Spider', 'getData'), array($oDetailsBot));
				//$sDetailsPage = removeTags($sDetailsPage);
				$oDetailsProcessor = Factory::factory($sDetailsPage, self::XSL_DETAILS);
				$sDetailsXml = $oDetailsProcessor->process($sDetailsPage, self::XSL_DETAILS);

				$aEmail = Utils::xmlToArray($sDetailsXml);
				if ($aEmail['result'])
					echo $item['name'] . ", " . $aEmail['result']['item']['email'] . "\n";
				$i++;
				$oDetailsBot->close();
			}

			$oBot->close();
		}

	}

	static public function getData($oBot) {
		return $oBot->get();
	}

}

Spider::run();




