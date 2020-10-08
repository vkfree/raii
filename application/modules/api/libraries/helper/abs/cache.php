<?php
namespace MatchMovePay\Helper\Abs;

interface Cache {

    public static function set($key, $value, $expire = 900);

    public static function get($key);
}