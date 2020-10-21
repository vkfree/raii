<?php
namespace MatchMovePay\Helper\Curl;

class Response {
    public $status = null;
    public $head = null;
    public $body = null;
    
    public function __construct($request, $verbose = false) {
        
        $response = curl_exec($request);
        $info = curl_getinfo($request);
        $status = curl_getinfo($request, CURLINFO_HTTP_CODE);
        
        $header = substr($response, 0, $info['header_size']);
        
        $body = 0 < (int) $info['download_content_length']
            ? substr($response, -$info['download_content_length'])
            : substr($response, $info['header_size']);
        
        $this->status = $status;
        $this->head = Response::parse_header($header);
        $this->body = $body;
        
        if ($verbose) {
            echo "\n< STATUS\n";
            echo $this->status;
            echo "\n< HEAD\n";
            print_r($this->head);
            echo "\n< BODY\n";
            print_r($this->body);
        }
    }

    public static function parse_header($head)
    {
        $template = [
            'Date'              => null,
            'WWW-Authenticate'  => null,
            'Transfer-Encoding' => null,
            'Content-Type'      => null,
        ];
            
        if (!is_array($head))
        {
            $head = trim($head);
            $head = explode("\n", $head);
        }
        
        $template['message'] = array_shift($head);
        
        for ($i = 0, $count = count($head); $i < $count; $i++)
        {
            foreach ($template as $index => $value)
            {
                if (0 === strpos($head[$i], $index . ':'))
                {
                    $template[$index] = trim(substr($head[$i], strlen($index) + 2));
                }
            }
        }
        
        return $template;
    }
}