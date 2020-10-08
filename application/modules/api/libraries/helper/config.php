<?php
namespace MatchMovePay\Helper;

use MatchMovePay\Helper\Exception;

class Config {
    
    private $data = [];
    
    public function __construct($namespace, $accepts, $path) {
        
        $config = [];
        
        foreach ($accepts as $item) {
            $name = strtoupper($namespace . str_replace('-', '_', $item));
            if (!empty($_SERVER[$name])) {
                $config[$item] = $_SERVER[$name];
            }
        }
        
        if (is_file($path)) {
            $config = array_merge($config, $this->load($path));
        }
            
        $this->apply($config, $accepts);
    }
    
    private function load($path) {
        if (!($config = json_decode(file_get_contents($path), true))) {
            throw new Exception(
                'Configuration file: `:file` is not a valid JSON format.', array(':file' => $path));
        }
        
        return $config;
    }
    
    public function __get($name) {
        if (!isset($this->data[$name])) {
            throw new Exception(
                'Configuration index: `:name` is undefined.', array(':name' => $name));
        }
        
        return $this->data[$name];
    }
    
    private function apply(array $config, $accepts) {
        foreach ($config as $key => $value) {
            if (in_array($key, $accepts)) {
                $this->data[$key] = $value;
            }
        }
    }
    
    public function as_array() {
        return $this->data;
    }
}