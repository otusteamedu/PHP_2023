<?php

class Solution {
    function make_fraction($numerator, $denominator, $fraction = "", $iterator = 0) {
        if ($iterator > 5000) {
            return $fraction;
        }
        
        $ceil_part = floor($numerator / $denominator);
        $numerator = $numerator % $denominator;
        
        if ($numerator == 0) {
            return $fraction . $ceil_part;
        }

        if ($iterator == 0) {
            $fraction = $ceil_part . '.';
        } else {
            $fraction .= $ceil_part;
        }
        
        if ($denominator > $numerator) {
            $numerator *= 10;
        } 
        
        return $this->make_fraction($numerator, $denominator, $fraction, ++$iterator);
    }

    function subpart_processing($subpart) {
        if (strlen($subpart) < 4999) {
            return $subpart;
        }
        $symbols = [];
        for ($i = 0; $i < strlen($subpart); $i++) {
            $symbol = substr($subpart, $i, 1);
            
            if (!isset($symbols[$symbol])) {
                $symbols[$symbol] = 0;
            }
            $symbols[$symbol]++;
        }
        
        $max_count = 0;
        $start = 0;
        $length = 0;
        for ($i = 1000; $i >= 1; $i--) {
            for ($j = 0; $j < 10; $j++) {
                $search = substr($subpart, $j, $i);
                $cnt = substr_count($subpart, $search.$search.$search)/3;
                if ($cnt > $max_count && $length <= $i) {
                    $max_count = $cnt;
                    $start = $j;
                    $length = $i;
                }
            }
        }
        
        $result = '';
        
        $i = 0;
        while ($i < $start) {
            $result .= substr($subpart, $i, 1);
            $i++;
        }
        
        $result .= '(' . substr($subpart, $start, $length) . ')';
        
        return $result;
    }

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        $prefix = "";
        if ($numerator * $denominator < 0) {
            $prefix = "-";
        }   
        
        $numerator = abs($numerator);
        $denominator = abs($denominator);
        
        $fraction = $this->make_fraction($numerator, $denominator);
        if (strpos($fraction, ".") === false) {
            return $prefix . $fraction;
        } else {
            $parts = explode(".", $fraction);
            return $prefix . $parts[0] . "." . $this->subpart_processing($parts[1]);
        }
    }
}