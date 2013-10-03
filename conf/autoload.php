<?php

function __autoload($sClassName){
    if(strpos($sClassName, '_')){
        $aClass = explode("_", $sClassName);
        $sFile = __DIR__ . "/../libs/" . $aClass[0] . "/" . $aClass[1] . ".class.php";
    }else{
	    $sFile = __DIR__ . "/../libs/" . $sClassName . ".class.php";
    }
	if(file_exists($sFile)){
		require_once $sFile;
	}
}