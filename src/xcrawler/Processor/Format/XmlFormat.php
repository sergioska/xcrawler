<?php

declare(strict_types = 1);

namespace xcrawler\Processor\Format;

use xcrawler\Processor\FormatService;

class XmlFormat implements FormatService
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return \DOMDocument
     */
    public function getCleanContent(): \DOMDocument
    {
        libxml_use_internal_errors(true);
        $this->content = \DOMDocument::loadXML($this->content);
        if ($this->content === false) {
            throw new Exception("Unable to load xmlFile");
        }
        libxml_clear_errors();
        return $this->content;
    }
}
