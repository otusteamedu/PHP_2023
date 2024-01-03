<?php

declare(strict_types=1);

namespace Common\Domain\User;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Geolocation\Domain\City;
use JsonSerializable;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 * )
 */
#[Entity, Table(name: 'users')]
final class User implements JsonSerializable
{
    /**
     * @var int|null The unique identifier of the user
     * @OA\Property(
     *     type="integer",
     *     description="The unique identifier of the user"
     * )
     */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    /**
     * @var string The email of the user
     * @OA\Property(
     *     type="string",
     *     description="The email of the user"
     * )
     */
    #[Column(name: 'email', type: 'string', length: 255, unique: true)]
    private string $email;

    /**
     * @var string The phone of the user
     * @OA\Property(
     *     type="string",
     *     description="The phone of the user"
     * )
     */
    #[Column(name: 'phone', type: 'string', length: 255, unique: true)]
    private string $phone;

    #[Column(name: 'password', type: 'string', length: 255)]
    protected string $password;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The username of the user"
     * )
     */
    #[Column(name: 'user_name', type: 'string', length: 255)]
    private string $username;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The first name of the user"
     * )
     */
    #[Column(name: 'user_first_name', type: 'string', length: 255)]
    private string $firstName;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The last name of the user"
     * )
     */
    #[Column(name: 'original_second_name', type: 'string', length: 255)]
    private string $lastName;

    /**
     * @var City
     * @OA\Property(
     *     type="Object",
     *     ref="#/components/schemas/City",
     *     description="The city of the user"
     * )
     */
    #[ManyToOne(targetEntity: City::class)]
    private City $city;

    public function __construct(
        ?int   $id,
        string $email,
        string $phone,
        string $password,
        City $city,
        string $username,
        string $firstName,
        string $lastName,
    )
    {
        $this->id = $id;
        $this->email = strtolower($email);
        $this->phone = strtolower($phone);
        $this->username = strtolower($username);
        $this->password = strtolower($password);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
        $this->city = $city;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
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
     * @return User
     */
    public function setEmail(string $email): User
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
     * @return User
     */
    public function setPhone(string $phone): User
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
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->email,
            'password' => $this->password,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return User
     */
    public function setCity(City $city): User
    {
        $this->city = $city;
        return $this;
    }
}
