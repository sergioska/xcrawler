<?php

/**
 * Bot actions
 * @author Sergio Sicari
 *
 */

namespace xcrawler;

use xcrawler\Curls;

class Bot extends Curls
{
    private $_sUrl;

    public function __construct()
    {
        $this->_sUrl = "";
        parent::__construct();
    }

    /**
     * Execute login operation in post
     * @param array() $aParams
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function login($aParams)
    {
        $this->setCookie();
        return $this->post($aParams);
    }

    /**
     * Execute a cUrl post request
     * @param array() $aParams
     *  post params
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function post($aParams=array())
    {
        $mResult = false;
        $sPostdata = "";
        if (!isset($this->_sUrl)) {
            return false;
        }
        if (!empty($aParams)) {
            foreach ($aParams as $key => $value) {
                $sPostdata .= $key . "=" . urlencode($value) . "&";
            }
            $sPostdata = substr($sPostdata, 0, -1);
            $aOptions[CURLOPT_POSTFIELDS] = $sPostdata;
        }
        $aOptions[CURLOPT_COOKIE] = $this->getCookie();
        $aOptions[CURLOPT_COOKIEJAR] = $this->getCookie();
        $aOptions[CURLOPT_REFERER] = $this->_sUrl;
        $aOptions[CURLOPT_POST] = 1;
        try {
            $this->setOptions($aOptions);
            $mResult = $this->execute();
        } catch (Exception $e) {
            $mResult = $e->getMessage();
        }
        return $mResult;
    }

    /**
     * Execute a cUrl get request
     * @param array() $aParams
     *  get params
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function get($aParams=array())
    {
        if ($this->_sUrl=="") {
            return false;
        }
        $mResult = false;
        $sGetdata = "";
        if (!empty($aParams)) {
            foreach ($aParams as $key => $value) {
                $sGetdata .= $key . "=" . urlencode($value) . "&";
            }
            $sGetdata = substr($sGetdata, 0, -1);
            $aOptions[CURLOPT_REFERER] = $this->_sUrl . "?" . $sGetdata;
        } else {
            $aOptions[CURLOPT_REFERER] = $this->_sUrl;
        }

        $aOptions[CURLOPT_POST] = 0;
        $aOptions[CURLOPT_FOLLOWLOCATION] = 1;
        $aOptions[CURLOPT_FOLLOWLOCATION] = 0;
        //$aOptions[CURLOPT_HEADER] = 0;
        $aOptions[CURLOPT_RETURNTRANSFER] = 1;
        try {
            $this->setOptions($aOptions);
            $mResult = $this->execute();
        } catch (Exception $e) {
            $mResult 	= $e->getMessage();
        }
        return $mResult;
    }

    public function getUrl()
    {
        return $this->_sUrl;
    }

    public function setUrl($sUrl)
    {
        $this->_sUrl = $sUrl;
        parent::setUrl($sUrl);
        $aOption[CURLOPT_URL] = $this->_sUrl;
        $this->setOptions($aOption);
    }
}
