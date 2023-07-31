<?php
declare(strict_types=1);

namespace After;

class User {
    private $name;
    private $email;
    private $isAdmin;

    public function __construct($name, $email, $isAdmin) {
        $this->name = $name;
        $this->email = $email;
        $this->isAdmin = $isAdmin;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }
}
