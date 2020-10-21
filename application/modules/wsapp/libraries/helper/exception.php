<?php
namespace MatchMovePay\Helper;

class Exception extends \Exception {
    
    public function __construct($message = '', array $data = array(), $code = 0, Exception $previous = null) {
        parent::__construct(strtr($message, $data), $code, $previous);
    }
}