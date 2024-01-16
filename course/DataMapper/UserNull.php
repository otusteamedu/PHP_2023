<?php

namespace DataMapper;

class UserNull extends User {
    public function __construct() {

    }

    public function getUsername() {
        return '';
    }

    public function getEmail() {
        return '';
    }

}
