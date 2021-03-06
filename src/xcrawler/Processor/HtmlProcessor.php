<?php

declare(strict_types = 1);

namespace xcrawler\Processor;

use xcrawler\Processor;
use xcrawler\Processor\Format\HtmlFormat;

class HtmlProcessor extends Processor
{
    /**
     * @param string $content
     * @return FormatService
     */
    public function format(string $content): FormatService
    {
        return new HtmlFormat($content);
    }
}
