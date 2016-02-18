<?php

namespace xcrawler;

class Utils {

	static public function xmlToArray($str) {
		$xml = simplexml_load_string($str, "SimpleXMLElement", LIBXML_NOCDATA);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		return $array;
	}

	static public function bufferize($sPath, $callback, $callback_params) {
		if(!file_exists($sPath)){
			$sPage = call_user_func_array($callback, $callback_params);
			file_put_contents($sPath, $sPage);
		}else{
			$sPage = file_get_contents($sPath);
		}
		return $sPage;
	}
}
