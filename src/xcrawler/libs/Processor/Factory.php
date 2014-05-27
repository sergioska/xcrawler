<?php

namespace xcrawler\libs\Processor;

use xcrawler\libs\Processor\Html;
use xcrawler\libs\Processor\Xml;


class Factory{
	public static function factory($sContents, $sStyleSheet){
		if (preg_match('~^[^<]*<\?xml[ ]~isU', $sContents)) {
			return new Xml($sContents, $sStyleSheet);
		}
		return new Html($sContents, $sStyleSheet);
	}
}