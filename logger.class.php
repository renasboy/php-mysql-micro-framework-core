<?php
namespace core;

class logger {

    // this is the verbosity level
    private $_level         = null;

    // these are the dependency objects library
    private $_debug         = null;
    private $_error         = null;

    public function __construct ($dir, $level) {
        $this->_level       = $level;
        $this->_debug       = $dir . '/debug.log';
        $this->_error       = $dir . '/error.log';
    }

    public function error ($message) {
        $this->_log($message, $this->_error, LOG_ERR);
    }

    public function debug ($message) {
        $this->_log($message, $this->_debug, LOG_DEBUG);
    }

    private function _log ($message, $file, $level) {
        if ($this->_level === null || $this->_level < $level) {
            return false;
        }
        $date       = date('Y-m-d H:i:s');
        $message    = sprintf('[%s] %s' . chr(10), $date, $message); 
        if (file_exists($file) && is_writable($file)) {
            error_log($message, 3, $file);
        }
    }
}
