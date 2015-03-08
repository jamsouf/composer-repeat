<?php

namespace Repeat;

/**
 * Repeater utility
 * @author Jamil Soufan (@jamsouf)
 */
class Repeat
{
    /**
     * Repeat calling a function
     * 
     * @param integer $count How often the function should be called
     * @param callable $func Function to call repeated
     * @param callable (optional) $until Repeat calling until this function returns true
     * @return array Results from each function call
     */
    public static function _function($count, $func, $until = null)
    {
        $results = array();
        
        for ($i = 0; $i < $count; $i++) {
            if ($until !== null && call_user_func($until, $results) === true) {
                break;
            }
            $results[] = call_user_func($func, $results);
        }
        
        return $results;
    }
    
    /**
     * Repeat a string
     * 
     * @param integer $count How often the string should be repeated
     * @param string $string String to repeat
     * @param callable (optional) $until Repeat the string until this function returns true
     * @param string (optional) $delimiter Signs to separate the strings
     * @return string Repeated string
     */
    public static function _string($count, $string, $until = null, $delimiter = null)
    {
        $result = '';
        
        for ($i = 0; $i < $count; $i++) {
            if ($until !== null && call_user_func($until, $result) === true) {
                break;
            }
            $newString = str_replace('{i}', $i, $string);
            $newString = str_replace('{j}', $i+1, $newString);
            $newString = $newString . $delimiter;
            $result .= $newString;
        }
        
        return trim($result, $delimiter);
    }
}