xCrawler
=======

xCrawler is a toolkit `FRAMEWORK AGNOSTIC` to develop spider application based on xsl stylesheets.

The simple example below show how to use this toolkit to parse a rss feed (yahoo news in this case) throw a xsl stylesheet to get in output a xml forged in another format. 

```php
<?php

require_once('vendor/autoload.php');

use xcrawler\Bot;


class Spider
{
    public function run(
	Processor $processor,
	string $content,
	string $stylesheet
    ): string
    {
	return $processor->process($content, $stylesheet);
    }
}

$spider = new Spider();
$bot = new Bot();
$bot->setUrl('http://www.example.com');
$stylesheet = 'stylesheet.xsl';
$content = $bot->get();
$output = $spider->run(new Processor\HtmlProcessor(), $content, $stylesheet);

echo $output

```

Toolkit parse xml or html source file in trasparent way; so in setUrl method, the only one parameter can set with an xml or html url. 
Above example use get method to retrieve code of source page, but also it is available post method for post request.

A more complex example is:

```php
<?php

require_once('vendor/autoload.php');

use xcrawler\Bot;
use xcrawler\Helpers\Utils;
use xcrawler\Processor;

class Spider
{

	const XSL_LIST = 'stylesheets/example.xsl';
	const URL_LIST = "http://www.example.comlist.php?ltr=%s";
	const XSL_DETAILS = 'stylesheets/example-details.xsl';
	const URL_DETAILS_BASE = 'http://www.example.com/x/details';
	const BUFFER_PATH = 'buffer/';

	public function run(Processor $processor)
	{

		$pages = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		for ($nPage=0; $nPage < count($pages); $nPage++) {

			$bot = new Bot();
			$bot->setUrl(sprintf(self::URL_LIST, $pages[$nPage]));
			$bot->setProxy('192.168.99.100:9050');
			$bot->setSOCKS5();
			$sPage = "";
			$sPage = Utils::bufferize(self::BUFFER_PATH . sprintf('buffer-%d.bak', $nPage), array('Spider', 'getData'), array($bot));

			$sXml = $processor->process($sPage, self::XSL_LIST);
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
				$sDetailsPage = Utils::bufferize(self::BUFFER_PATH . $bak, array('Spider', 'getData'), array($oDetailsBot));

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

$spider = new Spider();
$spider->run(new Processor\HtmlProcessor());

```


Install
=======

xCrawler can be install via composer as follow:

```bash
php composer.phar install
```



