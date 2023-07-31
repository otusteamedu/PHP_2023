<?php
declare(strict_types=1);

class User {
    public $name;
    public $email;
    public $isAdmin;

    public function __construct($name, $email, $isAdmin) {
        $this->name = $name;
        $this->email = $email;
        $this->isAdmin = $isAdmin;
    }

    public function sendEmail($subject, $message) {
        // Code to send email
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

    public function save() {
        // Code to save user data to the database
    }

    public function logActivity($activity) {
        // Code to log user activity
    }
}
