<?php

class Processor_Html_Xsl{

    public $_xslFile;

    public function __construct($stylesheet) {
        $this->_xslFile = $stylesheet;
    }

    /**
     * @param $xml
     * @throws Exception
     * @return string A single SQL query string.
     */
    public function transformXml($xml) {

        if(false === ($stylesheet = @DOMDocument::load($this->_xslFile))) {
            throw new Exception("Unable to load {$this->_xslFile}");
        }

        $processor = new XSLTProcessor();
        $processor->importStylesheet($stylesheet);
        $processor->registerPHPFunctions();
        
        if(false === ($transformationResult = $processor->transformToXML($xml))) {
            throw new Exception("Transformation of {$xmlFile} failed");        
        }
                
        if(!is_string($transformationResult) || strlen($transformationResult) == 0) {
            throw new Exception("Xsl transformation for {$xmlFile} returned no result");
        }                
                 
        return $transformationResult;
        
    }

    public function setStyleSheet($sStyleSheet){
        $this->_xslFile = $sStyleSheet;
    }
    
}