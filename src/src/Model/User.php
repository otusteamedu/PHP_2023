<?php

namespace App\Model;

/**
 * User model
 */
class User
{
    /**
     * User id
     *
     * @var int
     */
    public $id;
    /**
     * User name
     *
     * @var string
     */
    public $name;
    /**
     * User email
     *
     * @var string
     */
    public $email;

    public function validateFields()
    {
        if (empty($this->name) || empty($this->email)) {
            return false;
        }
        if (!is_string($this->name) || !is_string($this->email)) {
            return false;
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}
