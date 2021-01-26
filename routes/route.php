<?php

class Route
{
    private $_getUri = array();
    private $_getMethod = array();
    private $_postUri = array();
    private $_postMethod = array();

    public function get($uri, $method = null)
    {
        $this->_getUri[] = '/' . trim($uri, '/');
        if ($method != null) {
            $this->_getMethod[] = $method;
        }
    }
    public function post($uri, $method = null)
    {
        $this->_postUri[] = '/' . trim($uri, '/');
        if ($method != null) {
            $this->_postMethod[] = $method;
        }
    }
    /**
     * Makes the thing run!
     */
    public function submit()
    {
        $methodType = $_SERVER['REQUEST_METHOD'];
        if ($methodType == 'GET') {
            $uriGetParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';
            $matchedPath = false;
            foreach ($this->_getUri as $key => $value) {
                if (preg_match("#^$value$#", $uriGetParam)) {
                    $matchedPath = true;
                    if (is_string($this->_getMethod[$key])) {
                        $useMethod = $this->_getMethod[$key];
                        new $useMethod();
                    } else {
                        call_user_func($this->_getMethod[$key]);
                    }
                }
            }
            if (!$matchedPath) {
                print_r("404 Not Found GET Route");
            }
        } else if ($methodType == 'POST') {
            $uriPostParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';
            $matchedPath = false;
            foreach ($this->_postUri as $key => $value) {
                if (preg_match("#^$value$#", $uriPostParam)) {
                    $matchedPath = true;
                    if (is_string($this->_postMethod[$key])) {
                        $useMethod = $this->_postMethod[$key];
                        new $useMethod();
                    } else {
                        call_user_func($this->_postMethod[$key]);
                    }
                }
            }
            if (!$matchedPath) {
                print_r("404 Not Found POST Route");
            }
        } else {
            print_r("Undefined method");
        }
    }
}
