<?php

declare(strict_types = 1);

namespace xcrawler\Processor;

interface FormatService
{
    /**
     * @return \DOMDocument
     */
    public function getCleanContent(): \DOMDocument;
}
