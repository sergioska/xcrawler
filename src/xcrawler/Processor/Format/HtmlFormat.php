<?php

declare(strict_types = 1);

namespace xcrawler\Processor\Format;

use xcrawler\Processor\FormatService;

class HtmlFormat implements FormatService
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return \DOMDocument
     * @throws \Exception
     */
    public function getCleanContent(): \DOMDocument
    {
        $this->content = mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8');

        $this->_fixIllegalClosedHtmlTagInsideScript();
        $this->content = $this->_cleaner($this->content);

        libxml_use_internal_errors(true);
        $this->content = \DOMDocument::loadHTML($this->content);
        if ($this->content === false) {
            throw new \Exception("Unable to load xmlFile");
        }

        return $this->content;
    }

    private function _cleaner(string $sXml)
    {
        $sXml = preg_replace('/^<!DOCTYPE.+?>/', '', $sXml);
        $sXml = $this->_removeTags($sXml);
        return $sXml;
    }

    private function _fixIllegalClosedHtmlTagInsideScript()
    {
        $sContents = preg_replace_callback(
            '~(<script[^>]*>)(.*?)(</script>)~si',
            'self::_cbFixIllegalClosedHtmlTagInsideScript',
            $this->content
        );

        $sPcreError = (string)preg_last_error();

        // Check for NULL return value of PCRE function on errors
        if (!isset($this->content)) {
            return false;
        }
        $this->content = $sContents;
    }

    public static function _cbFixIllegalClosedHtmlTagInsideScript(array $aMatch)
    {
        return $aMatch[1] . preg_replace('~</([a-zA-Z])~', '<\/$1', $aMatch[2]) . $aMatch[3];
    }

    private function _removeTags(string $sPage): string
    {
        $sPage = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $sPage);
        $sPage = preg_replace('#<head>(.*?)</head>#is', '', $sPage);
        $sPage = str_replace("&nbsp;", "", $sPage);
        return $sPage;
    }
}
