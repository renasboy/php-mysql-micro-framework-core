<?php
namespace core;

class validator {

    private $_results    = [];

    public function error () {
        foreach ($this->_results as $rule => $result) {
            // Something fail return the failure data
            if (!$result) {
                return $rule;
            }
        }
        // NO errors, return false
        return false;
    }

    public function validate ($method, $value, $option = [], $extra = []) {
        // TODO check a better way to do this, returning the failure for logging
        $this->_results[$method . '(' . print_r($value, 1) . ',' . print_r($option, 1) . ')'] = $this->$method($value, $option, $extra);
    }

    public function is_in_list ($value, $list) {
        return in_array($value, $list);
    }

    public function is_equal ($value1, $value2) {
        return $value1 == $value2;
    }

    // I know, I know, but this helps in the validation
    public function is_array ($value) {
        return is_array($value) && count($value);
    }

    public function is_number ($value) {
        return is_int($value) || intval($value) > 0;
    }

    public function is_text ($value) {
        return is_string($value) && strlen($value) !== 0 && strlen($value) == strlen(strip_tags($value));
    }

    // basically this is a is_true (is_one) method
    public function is_flag ($value) {
        // this forces the flag to be always true
        return is_bool($value) | $value == 1;
    }

    public function is_date ($value) {
        // ####-##-##
        return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $value);
    }

    public function is_time ($value) {
        // ##:##:##
        return preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $value);
    }
    
    public function is_datetime ($value) {
        // ####-##-## ##:##:##
        return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $value);
    }

    public function is_website ($value) {
        return preg_match('/^(https?:\/\/)?([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})\/?$/', $value);
    }

    public function is_url ($value) {
        return preg_match('/^(https?:\/\/)?([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})\/([A-Za-z0-9_\-\.]\/?)+$/', $value);
    }

    public function is_email ($value) {
        return preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $value);
    }

    public function is_error_code ($value) {
        return in_array($value, [400, 401, 402, 403, 404, 405, 500, 501]);
    }
}
