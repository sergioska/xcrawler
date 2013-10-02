<?php

/**
 * cUrl Processor
 * Implements methods for curl actions.
 * @author sergioska
 *
 */

class CurlProcessor{

    private $_hCurl;
    private $_sUrl;
    private $_sCookies;
    protected $_aOptions;

    /**
     * curl options and properties init
     */
    function __construct(){
        $this->_hCurl = null;
        $this->_sUrl = null;
        $this->_sCookies = null;
        $this->_aOptions = array(
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_RETURNTRANSFER => 1,
        );
        $this->_hCurl = curl_init();
        curl_setopt_array($this->_hCurl , $this->_aOptions);
    }

    /**
     * curl options setting
     * @param $aOptions
     * @return void
     */
    public function setOptions($aOptions){
        foreach($aOptions as $key => $value){
            curl_setopt($this->_hCurl, $key, $value);
        }
    }

    /**
     * curl execution
     * @throws Excpetion
     * @return mixed
     */
    public function execute(){
        $mResult = curl_exec ($this->_hCurl);
        if(!$mResult)
            throw new Excpetion(curl_error($this->_hCurl));
        return $mResult;
    }

    /**
     * execute a curl request for cookie setting
     * @return boolean
     */
    public function setCookie(){
        if(!isset($this->_sUrl))
            return false;
        $hCurl = curl_init($this->_sUrl);
        curl_setopt($hCurl, CURLOPT_URL, $this->_sUrl);
        curl_setopt($hCurl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($hCurl, CURLOPT_HEADER, true);
        curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, 1);
        $sData = curl_exec($hCurl);
        curl_close($hCurl);
        preg_match_all('|Set-Cookie: (.*);|U', $sData, $aMatches);
        $sCookies = implode('; ', $aMatches[1]);
        $this->_sCookies = $sCookies;
        return true;
    }

    /**
     * get cookie value
     * @return string
     */
    public function getCookie(){
        return $this->_sCookies;
    }

    /**
     * Close cUrl handler
     * @return void
     */
    public function close(){
        if(isset($this->_hCurl))
            curl_close($this->_hCurl);
    }

    /**
     * get current curl handle
     * @return object
     */
    public function getCurl(){
        return $this->_hCurl;
    }

    /**
     * url setting
     * @param $sUrl
     */
    public function setUrl($sUrl){
        $this->_sUrl = $sUrl;
    }

}