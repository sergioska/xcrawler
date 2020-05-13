<?php

declare(strict_types = 1);

namespace xcrawler\Helpers;

class Utils
{
    /**
     * @param string $str
     * @return array
     */
    public static function xmlToArray(string $str): array
    {
        $xml = simplexml_load_string($str, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array;
    }

    /**
     * @param string $sPath
     * @param callable $callback
     * @param array $callback_params
     * @return string
     */
    public static function bufferize(string $sPath, callable $callback, array $callback_params): string
    {
        if (!file_exists($sPath)) {
            $sPage = call_user_func_array($callback, $callback_params);
            file_put_contents($sPath, $sPage);
        } else {
            $sPage = file_get_contents($sPath);
        }
        return $sPage;
    }
}
