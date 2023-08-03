<?php

declare(strict_types=1);

namespace Root\App\tableGateway;

use DateTime;
use Exception;
use Root\App\enum\Sex;

class PersonTableGatewayDto
{
    public ?string $id = null;
    public ?DateTime $addTimestamp = null;
    public string $fam;
    public ?string $nam = null;
    public ?string $otc = null;
    public ?DateTime $birthday = null;
    public ?string $nom = null;
    public ?string $prenom = null;
    public ?Sex $sex = null;

    /**
     * @param string|null $id
     * @return PersonTableGatewayDto
     */
    public function setId(?string $id): PersonTableGatewayDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param DateTime|string|null $addTimestamp
     * @return PersonTableGatewayDto
     * @throws Exception
     */
    public function setAddTimestamp(DateTime|string|null $addTimestamp): PersonTableGatewayDto
    {
        if ($addTimestamp instanceof DateTime) {
            $this->addTimestamp = $addTimestamp;
        } elseif (is_string($addTimestamp)) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u', $addTimestamp);
            if ($date === false) {
                throw new Exception("Error convert string to date ({$addTimestamp})");
            }
            $this->addTimestamp = $date;
        } elseif ($addTimestamp === null) {
            $this->addTimestamp = null;
        }
        return $this;
    }

    /**
     * @param string $fam
     * @return PersonTableGatewayDto
     */
    public function setFam(string $fam): PersonTableGatewayDto
    {
        $this->fam = $fam;
        return $this;
    }

    /**
     * @param string|null $nam
     * @return PersonTableGatewayDto
     */
    public function setNam(?string $nam): PersonTableGatewayDto
    {
        $this->nam = $nam;
        return $this;
    }

    /**
     * @param string|null $otc
     * @return PersonTableGatewayDto
     */
    public function setOtc(?string $otc): PersonTableGatewayDto
    {
        $this->otc = $otc;
        return $this;
    }

    /**
     * @param DateTime|string|null $birthday
     * @return PersonTableGatewayDto
     * @throws Exception
     */
    public function setBirthday(DateTime|string|null $birthday): PersonTableGatewayDto
    {
        if ($birthday instanceof DateTime) {
            $this->birthday = $birthday;
        } elseif (is_string($birthday)) {
            $date = DateTime::createFromFormat('Y-m-d', $birthday);
            if ($date === false) {
                throw new Exception("Error convert string to date ({$birthday})");
            }
            $this->birthday = $date;
        } elseif ($birthday === null) {
            $this->birthday = null;
        }
        return $this;
    }

    /**
     * @param string|null $nom
     * @return PersonTableGatewayDto
     */
    public function setNom(?string $nom): PersonTableGatewayDto
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @param string|null $prenom
     * @return PersonTableGatewayDto
     */
    public function setPrenom(?string $prenom): PersonTableGatewayDto
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @param string|Sex|null $sex
     * @return PersonTableGatewayDto
     */
    public function setSex(string|Sex|null $sex): PersonTableGatewayDto
    {
        if ($sex instanceof Sex) {
            $this->sex = $sex;
        } elseif (is_string($sex)) {
            $this->sex = Sex::from($sex);
        } elseif ($sex === null) {
            $this->sex = null;
        }
        return $this;
    }
}
