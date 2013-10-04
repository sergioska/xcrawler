<?php

class Processor_Factory{
	public static function factory($sContents, $sStyleSheet){
		if (preg_match('~^[^<]*<\?xml[ ]~isU', $sContents)) {
			return new Processor_Xml($sContents, $sStyleSheet);
		}
		return new Processor_Html($sContents, $sStyleSheet);
	}
}