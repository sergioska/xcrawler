xCrawler
=======

xCrawler is a toolkit to develop spider application based on xsl stylesheets.

The simple example below show how to use this toolkit to parse a rss feed (yahoo news in this case) throw a xsl stylesheet to get in output a xml forged in another format. 

```php
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

```

Toolkit parse xml or html source file in trasparent way; so in setUrl method, the only one parameter can set with an xml or html url. 
Above example use get method to retrieve code of source page, but also it is available post method for post request.




