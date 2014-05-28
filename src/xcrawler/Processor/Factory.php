<?php

namespace xcrawler\Processor;

use xcrawler\Processor\Html;
use xcrawler\Processor\Xml;


class Factory{
	public static function factory($sContents, $sStyleSheet){
		if (preg_match('~^[^<]*<\?xml[ ]~isU', $sContents)) {
			return new Xml($sContents, $sStyleSheet);
		}
		return new Html($sContents, $sStyleSheet);
	}
}