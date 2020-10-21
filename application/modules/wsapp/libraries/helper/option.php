<?php
namespace MatchMovePay\Helper;

class Option {
    protected static $input = [];
    
    protected static $flag = [];
    
    public static function get($input, $flag) {
        
        Option::$input = $input;
        Option::$flag = $flag;
        
        $input = array_merge(array_keys(Option::$input), array_values(Option::$input));
        
        array_walk($input, function (& $item) {
            $item .= ':';
        });
        
        $input = array_chunk($input, count(Option::$input));
        
        $short = array_merge($input[0], array_keys(Option::$flag));
        $long = array_merge($input[1], array_values(Option::$flag));
        
        $options = getopt(implode('', $short), $long);
        
        $uncaught = Option::get_uncaught($options);
        
        Option::simplify($options);
        
        return array_merge($options, $uncaught);
    }
    
    private static function simplify(array & $options) {            
        foreach (Option::$input as $short => $long) {
            if (!isset($options[$short])) {
                continue;
            }
            
            $options[$long] = !isset($options[$long])
                ? $options[$short]
                : array_merge(
                    !is_array($options[$long]) ? [$options[$long]]: $options[$long],
                    !is_array($options[$short]) ? [$options[$short]]: $options[$short]);
            
            unset($options[$short]);
        }
        
        foreach (Option::$flag as $short => $long) {
            if (!isset($options[$short])) {
                continue;
            }
            
            if (!isset($options[$long])) {
                $options[$long] = $options[$short];
            }
            
            unset($options[$short]);
        }
    }
    
    public static function get_uncaught(array & $caught) {
        $uncaught  = $_SERVER['argv'];
        array_shift($uncaught);
        
        foreach ($caught as $key => $value) {
            
            if (empty($uncaught)) {
                break;
            }
            
            if (1 < strlen($key)) {
                Option::unset_uncaught_long($uncaught, $key, $value);
                continue;
            }
            
            Option::unset_uncaught_short($uncaught, $key, $value);
        }
        
        return $uncaught;
        
    }
    
    private static function is_opt_format($subject, $key, $value) {
        return $key . '=' . $value == $subject || $key . '=\'' . $value . '\'' == $subject
            || $key . '="' . $value . '"' == $subject;
    }
    
    private static function unset_uncaught_long(array & $uncaught, $key, $value) {
        for ($pkey = '--' . $key, $i = 0, $count = count($uncaught); $i < $count; $i++) {
            if (false === $value && $pkey === $uncaught[$i])
            {
                unset($uncaught[$i]);
                break;
            }

            $value = is_array($value) ? $value: array($value);
            
            if ($pkey === $uncaught[$i] && !empty($uncaught[$i + 1]) && in_array($uncaught[$i + 1], $value))
            {
                unset($uncaught[$i], $uncaught[++$i]);
                continue;
            }
            
            foreach ($value as $item) {
                if (Option::is_opt_format($uncaught[$i], $pkey, $item)) {
                    unset($uncaught[$i]);
                }
            }
        }

        $uncaught = array_merge($uncaught);
    }
    
    private static function unset_uncaught_short(array & $uncaught, $key, $value) {
        for ($pkey = '-' . $key, $i = 0, $count = count($uncaught); $i < $count; $i++) {
            if (false === $value && $pkey === $uncaught[$i])
            {
                unset($uncaught[$i]);
                break;
            }

            $value = is_array($value) ? $value: array($value);
            
            if ($pkey === $uncaught[$i] && !empty($uncaught[$i + 1]) && in_array($uncaught[$i + 1], $value))
            {
                unset($uncaught[$i], $uncaught[++$i]);
                continue;
            }

            foreach ($value as $item) {
                if ($pkey . $item == $uncaught[$i] || Option::is_opt_format($uncaught[$i], $pkey, $item)) {
                    unset($uncaught[$i]);
                }
            }
        }

        $uncaught = array_merge($uncaught);
    }
}