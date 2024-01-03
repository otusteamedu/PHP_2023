<?php

namespace Ad\Infrastructure;

use Ad\Domain\Status;
use Ad\Domain\Type;
use Common\Domain\Phone;
use FileStorage\Domain\Entity\File;
use Geolocation\Domain\City;
use Psr\Http\Message\UploadedFileInterface;

class AdDTO
{
    private string $title;
    private string $description;
    private array $photo;
    private int $price;
    private Type $type;
    private City $city;
    private Status $status = Status::NEW;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return AdDTO
     */
    public function setTitle(string $title): AdDTO
    {
        $this->title = $title;
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
     * @return AdDTO
     */
    public function setDescription(string $description): AdDTO
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return File[]
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @param UploadedFileInterface[] $photo
     * @return AdDTO
     */
    public function setPhoto(array $photo): AdDTO
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return AdDTO
     */
    public function setPrice(int $price): AdDTO
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return AdDTO
     */
    public function setStatus(Status $status): AdDTO
    {
        $this->status = $status;
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
     * @return AdDTO
     */
    public function setType(Type $type): AdDTO
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
     * @return AdDTO
     */
    public function setCity(City $city): AdDTO
    {
        $this->city = $city;
        return $this;
    }
}