<?php

/**
 * Bot actions
 * @author Sergio Sicari
 *
 */

namespace xcrawler;

class Bot extends Curls
{
    private $url;

    public function __construct()
    {
        $this->url = "";
        parent::__construct();
    }

    /**
     * Execute login operation in post
     * @param array() $aParams
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function login($params)
    {
        $this->setCookie();
        return $this->post($params);
    }

    /**
     * Execute a cUrl post request
     * @param array() $aParams
     *  post params
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function post($params=array())
    {
        $postContent = "";
        if (!isset($this->url)) {
            return false;
        }
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $postContent .= $key . "=" . urlencode($value) . "&";
            }
            $postContent = substr($postContent, 0, -1);
            $options[CURLOPT_POSTFIELDS] = $postContent;
        }
        $options[CURLOPT_COOKIE] = $this->getCookie();
        $options[CURLOPT_COOKIEJAR] = $this->getCookie();
        $options[CURLOPT_REFERER] = $this->url;
        $options[CURLOPT_POST] = 1;
        try {
            $this->setOptions($options);
            $result = $this->execute();
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Execute a cUrl get request
     * @param array() $aParams
     *  get params
     *  Ex.: array('username_field' => 'blahblah', 'password_field' => ...', ...);
     * @return mixed
     */
    public function get($params=array())
    {
        if ($this->url=="") {
            return false;
        }
        $dataContent = "";
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $dataContent .= $key . "=" . urlencode($value) . "&";
            }
            $dataContent = substr($dataContent, 0, -1);
            $options[CURLOPT_REFERER] = $this->url . "?" . $dataContent;
        } else {
            $options[CURLOPT_REFERER] = $this->url;
        }

        $options[CURLOPT_POST] = 0;
        $options[CURLOPT_FOLLOWLOCATION] = 1;
        $options[CURLOPT_FOLLOWLOCATION] = 0;
        $options[CURLOPT_RETURNTRANSFER] = 1;
        try {
            $this->setOptions($options);
            $result = $this->execute();
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        parent::setUrl($url);
        $options[CURLOPT_URL] = $this->url;
        $this->setOptions($options);
    }
}
