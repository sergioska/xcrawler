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
            $page = Utils::bufferize(self::BUFFER_PATH . sprintf('buffer-%d.bak', $nPage), array('Spider', 'getData'), array($bot));

            $xmlContent = $processor->process($page, self::XSL_LIST);
            $xmlItems = Utils::xmlToArray($xmlContent);

            $i=0;
            foreach ($xmlItems['result']['item'] as $item) {
                if (empty($item['name'])) {
                    continue;
                }

                $detailsBot = new Bot();
                $detailsBot->setProxy('192.168.99.100:9050');
                $detailsBot->setSOCKS5();
                $detailsBot->setUrl(self::URL_DETAILS_BASE . $item['link']);
                $bak = sprintf('buffer-details-%d-%d.bak', $nPage, $i);
                $detailsPage = Utils::bufferize(self::BUFFER_PATH . $bak, array('Spider', 'getData'), array($detailsBot));

                $oDetailsProcessor = Factory::factory($detailsPage, self::XSL_DETAILS);
                $detailsXml = $oDetailsProcessor->process($detailsPage, self::XSL_DETAILS);
                $emails = Utils::xmlToArray($detailsXml);
                if ($emails['result']) {
                    echo $item['name'] . ", " . $emails['result']['item']['email'] . "\n";
                }
                $i++;
                $detailsBot->close();
            }

            $bot->close();
        }
    }

    public static function getData($oBot)
    {
        return $oBot->get();
    }
}

$spider = new Spider();
$spider->run(new Processor\HtmlProcessor());
