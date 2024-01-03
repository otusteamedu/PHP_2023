<?php

namespace Ad\Domain;

use Ad\Infrastructure\Repository\AdRepository;
use Common\Domain\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\PersistentCollection;
use Geolocation\Domain\City;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Ad",
 *     description="Ad model",
 * )
 */
#[Entity(repositoryClass: AdRepository::class), Table(name: 'ads')]
class Ad
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="The unique identifier of the ad"
     * )
     * @var int|null
     */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    /**
     * @OA\Property(
     *     type="Object",
     *     ref="#/components/schemas/User",
     *     description="The user who created the ad"
     *
     * )
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    /**
     * @var string The title of the ad
     * @OA\Property(
     *     type="string",
     *     description="The title of the ad"
     * )
     */
    #[Column(type: 'string', nullable: false)]
    private string $title;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The price of the ad"
     * )
     */
    #[Column(type: 'integer', nullable: false)]
    private string $price;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The description of the ad"
     * )
     */
    #[Column(type: 'text', nullable: false)]
    private string $description;

    /**
     * @var Status
     * @OA\Property(
     *     type="string",
     *     description="The status of the ad"
     * )
     */
    #[Column(type: 'string', nullable: false, enumType: Status::class)]
    private Status $status = Status::NEW;

    /**
     * @var Type
     * @OA\Property(
     *     type="string",
     *     description="The type of the ad"
     * )
     */
    #[Column(type: 'string', nullable: false, enumType: Type::class)]
    private Type $type;

    /**
     * @var City
     * @OA\Property(
     *     type="Object",
     *     ref="#/components/schemas/City",
     *     description="The city of the ad"
     * )
     */
    #[ORM\ManyToOne(targetEntity: City::class, fetch: 'EAGER'), ORM\JoinColumn(name: 'city_id', referencedColumnName: 'id')]
    private City $city;

    /**
     * @var \DateTimeImmutable
     */
    #[Column(name: 'registered_at', type: 'datetimetz_immutable', nullable: false)]
    private \DateTimeImmutable $registeredAt;

    /**
     * @var Collection|ArrayCollection
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AdFile")
     * )
     */
    #[ORM\OneToMany(targetEntity: AdFile::class, mappedBy: 'ad', fetch: 'EAGER')]
    private Collection $photo;

    public function __construct()
    {
        $this->setRegisteredAt(new \DateTimeImmutable());
        $this->setStatus(Status::NEW);
        $this->photo = new ArrayCollection();
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
     * @return Ad
     */
    public function setId(?int $id): Ad
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Ad
     */
    public function setUser(User $user): Ad
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Ad
     */
    public function setTitle(string $title): Ad
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Ad
     */
    public function setPrice(string $price): Ad
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Ad
     */
    public function setDescription(string $description): Ad
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \Ad\Domain\Status
     */
    public function getStatus(): \Ad\Domain\Status
    {
        return $this->status;
    }

    /**
     * @param \Ad\Domain\Status $status
     * @return Ad
     */
    public function setStatus(\Ad\Domain\Status $status): Ad
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    /**
     * @param \DateTimeImmutable $registeredAt
     * @return Ad
     */
    public function setRegisteredAt(\DateTimeImmutable $registeredAt): Ad
    {
        $this->registeredAt = $registeredAt;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Ad
     */
    public function setType(Type $type): Ad
    {
        $this->type = $type;
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
     * @param City $city
     * @return Ad
     */
    public function setCity(City $city): Ad
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }
}
