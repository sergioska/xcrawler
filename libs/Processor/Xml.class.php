<?php

class Processor_Xml extends Processor{
	public function process($sXmlCode, $sStyleSheet){
        $this->_sCode = $sXmlCode;
        libxml_use_internal_errors(true);
        if(false === ($this->_sCode = DOMDocument::loadHTML($this->_sCode))) {
            throw new Exception("Unable to load {$xmlFile}");
        }
        $oXsl = new Processor_Html_Xsl($sStyleSheet);
        $sXml = $oXsl->transformXml($this->_sCode);
        libxml_clear_errors();
        return $sXml;
	}
}