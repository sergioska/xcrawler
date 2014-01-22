<?php

class Processor_Html extends Processor{

	private $_sCode;

	public function process($sHtmlCode, $sStyleSheet){

		$this->_sCode = $sHtmlCode;
		$this->_sCode = mb_convert_encoding($this->_sCode, 'HTML-ENTITIES', 'UTF-8');

		$this->_fixIllegalClosedHtmlTagInsideScript();
		$this->_sCode = $this->_cleaner($this->_sCode);

        libxml_use_internal_errors(true);
		if(false === ($this->_sCode = DOMDocument::loadHTML($this->_sCode))) {
            throw new Exception("Unable to load {$xmlFile}");
        }
		
		$oXsl = new Processor_Html_Xsl($sStyleSheet);
		$sXml = $oXsl->transformXml($this->_sCode);
        libxml_clear_errors();
		return $sXml;
	}

	private function _cleaner($sXml){
		$sXml = preg_replace('/^<!DOCTYPE.+?>/', '', $sXml);
		return $sXml;
	}

	private function _fixIllegalClosedHtmlTagInsideScript()
	{

		if (!function_exists('_cbFixIllegalClosedHtmlTagInsideScript')) {
			function _cbFixIllegalClosedHtmlTagInsideScript($aMatch) {
				return $aMatch[1] . preg_replace('~</([a-zA-Z])~', '<\/$1', $aMatch[2]) . $aMatch[3];
			}
		}

		$sContents = preg_replace_callback(
			'~(<script[^>]*>)(.*?)(</script>)~si',
			'_cbFixIllegalClosedHtmlTagInsideScript',
			$this->_sCode
		);

		$sPcreError = (string)preg_last_error();

		// Check for NULL return value of PCRE function on errors
		if (!isset($this->_sCode)) {
			return false;
		}

		$this->_sCode = $sContents;
	}

}
