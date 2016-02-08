xCrawler
=======

xCrawler is a toolkit to develop spider application based on xsl stylesheets.

The simple example below show how to use this toolkit to parse a rss feed (yahoo news in this case) throw a xsl stylesheet to get in output a xml forged in another format. 

```php

require_once('vendor/autoload.php');

use xcrawler\Bot;
use xcrawler\Processor\Factory;

define ('XSL_TEST', 'stylesheets/test.xsl');

$oBot = new Bot();

if(!file_exists('buffer.xml')){
        $oBot->setUrl("http://www.example.com");
        $aParams = array('post_key' => 'post_value');
        $sPage = $oBot->post($aParams);
        file_put_contents('buffer.xml', $sPage);
}else{
        $sPage = file_get_contents('buffer.xml');
}

$oProcessor = Factory::factory($sPage, XSL_TEST);
$sXml = $oProcessor->process($sPage, XSL_TEST);

echo $sXml;

```

Toolkit parse xml or html source file in trasparent way; so in setUrl method, the only one parameter can set with an xml or html url. 
Above example use get method to retrieve code of source page, but also it is available post method for post request.

A more complex example is:

```php
require_once('vendor/autoload.php');

use xcrawler\Bot;
use xcrawler\Processor\Factory;
use xcrawler\Utils;


class Spider
{

	const XSL_LIST = 'stylesheets/example.xsl';
	const URL_LIST = "http://www.example.comlist.php?ltr=%s";
	const XSL_DETAILS = 'stylesheets/example-details.xsl';
	const URL_DETAILS_BASE = 'http://www.example.com/x/details';
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
			$sPage = Utils::bufferize($oBot, self::BUFFER_PATH . sprintf('buffer-%d.bak', $nPage), $sPage);

			$oProcessor = Factory::factory($sPage, self::XSL_LIST);
			$sXml = $oProcessor->process($sPage, self::XSL_LIST);
			$aXml = Utils::xmlToArray($sXml);

			$i=0;
			foreach($aXml['result']['item'] as $item) {

				if(empty($item['name']))
					continue;

				$oDetailsBot = new Bot();
				$oDetailsBot->setProxy('192.168.99.100:9050');
				$oDetailsBot->setSOCKS5();
				$oDetailsBot->setUrl(self::URL_DETAILS_BASE . $item['link']);
				$sDetailsPage = "";
				$bak = sprintf('buffer-details-%d-%d.bak', $nPage, $i);
				$sDetailsPage = Utils::bufferize($oDetailsBot, self::BUFFER_PATH . $bak, $sDetailsPage);

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

}

Spider::run();

```


Install
=======

xCrawler can be install via composer as follow:

```bash
php composer.phar install
```



