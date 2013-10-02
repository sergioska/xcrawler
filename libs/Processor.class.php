<?php

class Processor{
	public static function factory($sContents, $sStyleSheet){
		if (preg_match('~^[^<]*<\?xml[ ]~isU', $sContents)) {
			return new XmlProcessor($sContents, $sStyleSheet);
		}
		return new HtmlProcessor($sContents, $sStyleSheet);
	}
}