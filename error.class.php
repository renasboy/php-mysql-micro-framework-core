<?php
namespace core;

class error {

    // these are the http messages and codes
    private $_codes             = [
        'bad_request'           => 400,
        'unauthorized'          => 401,
        'payment_required'      => 402,
        'forbidden'             => 403,
        'not_found'             => 404,
        'precondition_failed'   => 412,
        'method_not_allowed'    => 405,
        'internal_server_error' => 500,
        'not_implemented'       => 501
    ];

    // these are the dependency objects library
    private $_logger            = null;

    public function __construct ($reporting, logger $logger) {
        error_reporting($reporting);
        $this->_logger = $logger;
    }

    public function __call ($error, $message) {
        if (!array_key_exists($error, $this->_codes)) {
            $this->internal_server_error('Unkown error: ' . $error);
        }
        $error_name    = strtoupper(str_replace('_', ' ', $error));
        $this->_logger->error($error_name . ' ' . $message[0]);
        throw new \Exception($error_name . ': ' . $message[0], $this->_codes[$error]);
    }
}
