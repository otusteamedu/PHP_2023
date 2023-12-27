<?php

namespace Elena\Hw11;

use Exception;
use http\Client\Request;


class App
{
    function __construct($argv){
        $this->argv = $argv;
        foreach($argv as $one){
            $args = explode(':',$one);
            switch($args[0]){
                case "-p":
                    $this->search_price = $args[1];
                    break;
                case "-w":
                    $this->search_word = $args[1];
                    break;
            }
        }
   }

   function run()
    {
          $elastic = new Elastic();
          $elastic->search_book($this->search_word,$this->search_price);
    }
}

