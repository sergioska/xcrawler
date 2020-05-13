<?php

/**
 * cUrl Processor
 * Implements methods for curl actions.
 * @author sergioska
 *
 */

namespace xcrawler;

class Curls
{

    const USER_AGENT = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6';
    const CURL_TIMEOUT = 60;
    const CURLOPT_SOCKS5_PROXYTYPE = 7;

    private $curlHandler;
    private $url;
    private $cookies;
    protected $options;

    /**
     * curl options and properties init
     */
    public function __construct()
    {
        $this->curlHandler = null;
        $this->url = null;
        $this->cookies = null;
        $this->options = array(
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => self::USER_AGENT,
            CURLOPT_TIMEOUT => self::CURL_TIMEOUT,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => 1,
        );
        $this->curlHandler = curl_init();
        curl_setopt_array($this->curlHandler, $this->options);
    }

    /**
     * curl options setting
     * @param $aOptions
     * @return void
     */
    public function setOptions($aOptions)
    {
        foreach ($aOptions as $key => $value) {
            curl_setopt($this->curlHandler, $key, $value);
        }
    }

    public function setProxy($address)
    {
        curl_setopt($this->curlHandler, CURLOPT_PROXY, $address);
    }

    public function setSOCKS5()
    {
        curl_setopt($this->curlHandler, CURLOPT_PROXYTYPE, self::CURLOPT_SOCKS5_PROXYTYPE);
    }

    /**
     * curl execution
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        $result = curl_exec($this->curlHandler);
        if (!$result) {
            throw new \Exception(curl_error($this->curlHandler));
        }
        return $result;
    }

    /**
     * execute a curl request for cookie setting
     * @return boolean
     */
    public function setCookie()
    {
        if (!isset($this->url)) {
            return false;
        }
        $curlHandler = curl_init($this->url);
        curl_setopt($curlHandler, CURLOPT_URL, $this->url);
        curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curlHandler, CURLOPT_HEADER, true);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        $contentData = curl_exec($curlHandler);
        curl_close($curlHandler);
        preg_match_all('|Set-Cookie: (.*);|U', $contentData, $matches);
        $cookies = implode('; ', $matches[1]);
        $this->cookies = $cookies;
        return true;
    }

    /**
     * get cookie value
     * @return string
     */
    public function getCookie()
    {
        return $this->cookies;
    }

    /**
     * Close cUrl handler
     * @return void
     */
    public function close()
    {
        if (isset($this->curlHandler)) {
            curl_close($this->curlHandler);
        }
    }

    /**
     * get current curl handle
     * @return object
     */
    public function getCurl()
    {
        return $this->curlHandler;
    }

    /**
     * url setting
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
