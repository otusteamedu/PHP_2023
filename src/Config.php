<?php

declare(strict_types=1);

namespace VLebedev\BookShop;

use VLebedev\BookShop\Exception\ConfigurationException;

class Config
{
    private string $elasticHost;
    private string $elasticIndex;
    private string $elasticUser;
    private string $elasticPassword;

    /**
     * @throws ConfigurationException
     */
    public function __construct() {
        if (!$host = getenv('ELASTIC_HOST')) {
            throw new ConfigurationException('Env variable ELASTIC_HOST missing');
        }
        if (!$index = getenv('ELASTIC_INDEX')) {
            throw new ConfigurationException('Env variable ELASTIC_HOST missing');
        }
        if (!$user = getenv('ELASTIC_USER')) {
            throw new ConfigurationException('Env variable ELASTIC_USER missing');
        }
        if (!$password = getenv('ELASTIC_PASSWORD')) {
            throw new ConfigurationException('Env variable ELASTIC_PASSWORD missing');
        }
        $this->elasticHost = $host;
        $this->elasticIndex = $index;
        $this->elasticUser = $user;
        $this->elasticPassword = $password;
    }

    /**
     * @return string
     */
    public function getElasticHost(): string
    {
        return $this->elasticHost;
    }

    /**
     * @return string
     */
    public function getElasticIndex(): string
    {
        return $this->elasticIndex;
    }

    /**
     * @return string
     */
    public function getElasticUser(): string
    {
        return $this->elasticUser;
    }

    /**
     * @return string
     */
    public function getElasticPassword(): string
    {
        return $this->elasticPassword;
    }
}
