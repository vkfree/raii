<?php
namespace MatchMovePay\Helper;

class Cache implements \MatchMovePay\Helper\Abs\Cache {
    public static $namespace = 'vcard';
    
    private static function file($key) {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . Cache::$namespace .hash('crc32b', $key) . '.tmp';
        
        return $file;
    }
    
    public static function set($key, $value, $expire = 900) {
        $payload = [
            'expire' => time() + (int) $expire,
            '_'      => $value
        ];
        
        file_put_contents(
            Cache::file($key), json_encode($payload));
        
    }
    
    public static function get($key) {
        $key = Cache::file($key);
        
        if (!is_file($key)) {
            return null;
        }
        
        $content = json_decode(file_get_contents($key), true);
        
        return empty($content) || !is_array($content)
            || empty($content['expire']) || empty($content['_']) || time() >= $content['expire']
            ? null
            : $content['_'];
    }
}