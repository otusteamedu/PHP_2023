<?php

namespace DataMapper;

class User {
    private $id;
    private $username;
    private $email;

    private $profile;

    public function __construct($id, $username, $email, $profile = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->profile = $profile;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    /**
     * @deprecated Lazy Load
     */
    public function getProfile() {
        if ($this->profile === null) {
            $profileMapper = new ProfileMapper();
            $this->profile = $profileMapper->findByUserId($this->id);
        }

        return $this->profile;
    }
}