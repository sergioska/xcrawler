<?php

namespace xcrawler;

class Utils {
	
	static public function xmlToArray($str) {
		$xml = simplexml_load_string($str, "SimpleXMLElement", LIBXML_NOCDATA);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		return $array;
	}

	static public function bufferize($oBot, $sPath, $sPage) {
		if(!file_exists($sPath)){
			$sPage = $oBot->get();
			file_put_contents($sPath, $sPage);
			sleep(rand(2,5));
		}else{
			$sPage = file_get_contents($sPath);
		}
		return $sPage;
	}
}
