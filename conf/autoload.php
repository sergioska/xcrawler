<?php

function __autoload($sClassName){
	$sFile = __DIR__ . "/../libs/" . $sClassName . ".class.php";
	if(file_exists($sFile)){
		require_once $sFile;
	}
}