<?php


class classLoader{
    public static function autoloader($sClassName){
        $sFile = __DIR__ . "/../libs";
        $sSuffix = "";
        if(strpos($sClassName, '_')){
            $aSubDirs = explode("_", $sClassName);
            $aClass = $aSubDirs;
            for($i=0; $i<count($aSubDirs); $i++)
                $sSuffix .= "/" . $aSubDirs[$i];
            $sFile .= $sSuffix . ".class.php";
        }else{
            $sFile = __DIR__ . "/../libs/" . $sClassName . ".class.php";
        }
        if(file_exists($sFile)){
            require_once $sFile;
        }
    }
}