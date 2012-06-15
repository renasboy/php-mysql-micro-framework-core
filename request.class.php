<?php
namespace core;

class request {

    const DEFAULT_METHOD    = 'get';

    // this is usually the _REQUEST array
    protected $_request     = null;

    // this is usually the _SERVER array
    protected $_server      = null;

    // these are the dependency objects library
    protected $_conf        = null;
    protected $_error       = null;

    public function __construct (
        $_request,
        $_server,
        conf    $conf,
        error   $error
    ) {
        $this->_request     = $_request;
        $this->_server      = $_server;
        $this->_conf        = $conf;
        $this->_error       = $error;

        $this->_append_params();
    }

    public function get ($key = null, $type = null) {
        // file upload
        if ($type == 'file') {
            if (!empty($_FILES) && array_key_exists($key, $_FILES) && $_FILES[$key]['error'] === 0) {
                return $_FILES[$key];
            }
            return null;
        }
        if (!array_key_exists($key, $this->_request)) {
            $this->_request[$key] = null;
        }
        switch ($type) {
            case 'int':
                return intval($this->_request[$key]);
            case 'string':
                return trim($this->_request[$key]);
            case 'safe_output':
                return trim(strip_tags($this->_request[$key]));
            default:
                return $this->_request[$key];
        }
    }

    public function uri () {
        $uri = null;
        if (array_key_exists('REQUEST_URI', $this->_server)) {
            $uri = substr(parse_url($this->_server['REQUEST_URI'], PHP_URL_PATH), 1);
        }
        return $uri;
    }

    public function method () {
        $method = self::DEFAULT_METHOD;
        if (array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_METHOD', $this->_server)) {
            $method = $this->_server['HTTP_ACCESS_CONTROL_REQUEST_METHOD'];
        }
        else if (array_key_exists('REQUEST_METHOD', $this->_server)) {
            $method = $this->_server['REQUEST_METHOD'];
        }
        $method = strtolower($method);
        if ($method == 'put') {
            $method = 'post';
        }
        return $method; 
    }

    public function time () {
        if (!array_key_exists('REQUEST_TIME', $this->_server)) {
            $this->_server['REQUEST_TIME'] = time();
        }
        return $this->_server['REQUEST_TIME'];
    }
}
?>
