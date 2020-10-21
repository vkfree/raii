<?php
namespace MatchMovePay\Helper;

use MatchMovePay\VCard\Security;

class OAuth {
    
    public static function get_nonce() {
        return hash('md5', time() . mt_rand() . microtime());
    }
    
    public static function urlencode($value) {
        if (!is_array($value)) {
            $value = mb_convert_encoding($value, 'UTF-8',
                mb_detect_encoding($value, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
            
            return str_replace('+', ' ', str_replace('%E7', '~', rawurlencode($value)));
        }
        
        ksort($value);
        
        $query = [];
        
        foreach($value as $i => $v) {
            array_push($query, OAuth::urlencode($i) . '=' . OAuth::urlencode($v));
        }
        
        return implode('&', $query);
    }
    
    public static function uriencode($value) {
        return strtr(rawurlencode($value),
            [
                '*' => '%2A',
                '!' => '%21',
                '\'' => '%27',
                '(' => '%28',
                ')' => '%29'
            ]);
    }
    
    public static function encrypt($secret, $signature, $payload) {
        
        if (is_array($secret)) {
            $secret = implode('', $secret);
        }
        
        $key = hash('md5', $signature . $secret);
        
        $sec = new Security($key);
        return $sec->encrypt($payload);
    }
}