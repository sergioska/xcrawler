<?php

declare(strict_types = 1);

namespace xcrawler\Processor;

use xcrawler\Processor;
use xcrawler\Processor\Format\XmlFormat;

class XmlProcessor extends Processor
{
    /**
     * @param string $content
     * @return FormatService
     */
    public function format(string $content): FormatService
    {
        return new XmlFormat($content);
    }
}
