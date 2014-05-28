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


Install
=======

```json
{
    "name": "xcrawler",
    "description": "toolkit to xml/html parser projects",
    "license": "Apache 2.0",
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "sergioska/xcrawler",
                "version": "dev-xcrawler",
                "source": {
                    "type": "git",
                    "url": "https://github.com/sergioska/xcrawler.git",
                    "reference": "origin"
                }
            }
        }
    ]
    ,"require": {
        "sergioska/xcrawler": "dev-xcrawler",
    }
    , "autoload": {
        "psr-0": {"xcrawler": "vendor/sergioska/xcrawler/src/"}
    }
}
```


```



