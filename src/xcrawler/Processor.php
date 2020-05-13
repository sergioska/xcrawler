<?php

declare(strict_types = 1);

namespace xcrawler;

use Webmozart\Assert\Assert;
use xcrawler\Processor\FormatService;

abstract class Processor
{

    /**
     * @param string $content
     * @return FormatService
     */
    abstract protected function format(string $content): FormatService;

    /**
     * @param string $content
     * @param string $stylesheetPath
     * @return string
     * @throws \Exception
     */
    public function process(string $content, string $stylesheetPath)
    {
        $formattedContent = $this->format($content);
        return $this->applyStylesheet($formattedContent, $stylesheetPath);
    }


    /**
     * @param FormatService $format
     * @param string $stylesheetPath
     * @return string
     * @throws \Exception
     */
    private function applyStylesheet(FormatService $format, string $stylesheetPath): string
    {

        Assert::isInstanceOf($format, FormatService::class);

        try {
            $xslDoc = new \DOMDocument();
            $xslDoc->load($stylesheetPath);
        } catch (\Exception $e) {
            throw new \Exception("Unable to load {$stylesheetPath}");
        }

        try {
            $xmlDoc = $format->getCleanContent();
        } catch (\Exception $e) {
            throw new \Exception("Unable to load xml content");
        }

        try {
            $xsltProcessor = new \XSLTProcessor();
            $xsltProcessor->importStylesheet($xslDoc);
            $xsltProcessor->registerPHPFunctions();
            $transformationResult = $xsltProcessor->transformToXML($xmlDoc);
        } catch (\Exception $e) {
            throw new \Exception("Transformation of xmlFile failed");
        }

        return $transformationResult;
    }
}
