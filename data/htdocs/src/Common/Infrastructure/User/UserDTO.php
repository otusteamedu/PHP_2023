<?php

namespace Common\Infrastructure\User;

use Geolocation\Domain\City;

class UserDTO
{
    public function __construct(
        private string $email,
        private string $phone,
        private string $password,
        private City $city,
        private ?int $id = null,
        private string $username = '',
        private string $firstName = '',
        private string $lastName = '',
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserDTO
     */
    public function setId(?int $id): UserDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserDTO
     */
    public function setEmail(string $email): UserDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return UserDTO
     */
    public function setPhone(string $phone): UserDTO
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserDTO
     */
    public function setPassword(string $password): UserDTO
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserDTO
     */
    public function setUsername(string $username): UserDTO
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserDTO
     */
    public function setFirstName(string $firstName): UserDTO
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserDTO
     */
    public function setLastName(string $lastName): UserDTO
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param int $city
     * @return UserDTO
     */
    public function setCity(int $city): UserDTO
    {
        $this->city = $city;
        return $this;
    }
}
