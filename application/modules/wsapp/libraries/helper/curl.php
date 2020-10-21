<?php
namespace MatchMovePay\Helper;

use MatchMovePay\Helper\Exception;
use MatchMovePay\Helper\Curl\Response;

class Curl {
    
    private $options_ssl = [];
    private $host = null;
    public static $verbose = false;
    
    public function factory($method, $api, array $data = []) {
        $method = strtolower($method);
        
        if (!in_array($method, array('get', 'post', 'put', 'delete'))) {
            throw new Exception('Unknown method :method', [':method' => $method]);
        }
        
        return $this->$method($api, $data);
    }
    
    public function __construct($host, $ssl_path = false) {
        
        $this->host = $host;
        
        if (!empty($ssl_path) && !is_file($ssl_path)) {
            throw new Exception(
                'SSL certificate file: `:file` cannot be found.', array(':file' => $ssl_path));
        }
        
        if (!empty($ssl_path))
        {
            $this->options_ssl = [
                CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_SSL_VERIFYPEER  => true,
                CURLOPT_SSL_VERIFYHOST  => 2,
                CURLOPT_CAINFO          => $ssl_path
            ];
        }
        elseif (0 === strpos($this->host, 'https://'))
        {
            $this->options_ssl = [
                CURLOPT_SSL_VERIFYPEER => false
            ];
        }
    }
    
    protected function execute(array $options = []) {
        $request = curl_init();
        
        if (0 === strpos(strtolower($options[CURLOPT_URL]), 'https://')) {
            foreach ($this->options_ssl as $key => $value)
            {
                $options[$key] = $value;
            }
        }
        
        $options[CURLOPT_HEADER] = true;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_VERBOSE] = true === Curl::$verbose;
        $options[CURLOPT_HTTPHEADER] = array('Expect:');
        
        curl_setopt_array($request, $options);
        
        return new Response($request, self::$verbose);
    }
    
    public function get($api, array $data = []) {
        return $this->execute([
            CURLOPT_URL            => $this->host . '/' . $api . '?' . http_build_query($data)
        ]);
    }
    
    public function post($api, array $data = []) {
        return $this->execute([
            CURLOPT_URL            => $this->host . '/' . $api,
            CURLOPT_POST           => count($data),
            CURLOPT_POSTFIELDS     => http_build_query($data, null, '&', PHP_QUERY_RFC3986)
        ]);
    }
    
    public function put($api, array $data = []) {
        return $this->execute([
            CURLOPT_URL            => $this->host . '/' . $api . '?' . http_build_query($data),
            CURLOPT_CUSTOMREQUEST  => 'PUT'
        ]);
    }
    
    public function delete($api, array $data = []) {
        return $this->execute([
            CURLOPT_URL            => $this->host . '/' . $api . '?' . http_build_query($data),
            CURLOPT_CUSTOMREQUEST  => 'DELETE'
        ]);
    }
}