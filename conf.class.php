<?php
namespace core;

class conf {

    private $_data   = [];
    private $_file   = null;
    private $_multi  = false;

    public function __construct ($file, $multi = false) {
        $this->_file     = $file;
        $this->_multi    = $multi;
    }

    private function _init () {
        if ($this->_data === []) {
            // TODO check if file exists
            $this->_data = parse_ini_file($this->_file, $this->_multi);
        }
    }

    public function get ($key = null) {
        $this->_init();
        if ($key === null) {
            return $this->_data;
        }
        if ($this->_multi && strpos($key, '.')) {
            list($section, $key) = explode('.', $key);
            if (array_key_exists($section, $this->_data) &&
                array_key_exists($key, $this->_data[$section])) {
                return $this->_data[$section][$key];
            }
        }
        else if (array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        }
        return null;
    }
}
