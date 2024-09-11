<?php

class Person {
    public $name;

    public function set_name( $name )
    {
        $this->name=$name;
    }

    public function getName($name) {
        return $this->name;
    }
} 