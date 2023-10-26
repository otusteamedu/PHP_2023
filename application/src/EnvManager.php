<?php

declare(strict_types=1);

namespace Gesparo\ES;

class EnvManager
{
    private const PATH_TO_ELASTIC_CERTIFICATE = 'ELASTIC_CA_PATH';
    private const ELASTIC_PASSWORD = 'ELASTIC_PASSWORD';
    private const PATH_TO_ELASTIC_BULK_FILE = 'ELASTIC_BULK_FILE_PATH';
    private const ELASTIC_INDEX = 'ELASTIC_INDEX';

    private array $envData;

    public static function getEnvParams(): array
    {
        return [
            self::PATH_TO_ELASTIC_CERTIFICATE,
            self::ELASTIC_PASSWORD,
            self::PATH_TO_ELASTIC_BULK_FILE,
            self::ELASTIC_INDEX
        ];
    }

    public function __construct(array $envData)
    {
        $this->envData = $envData;
    }

    public function getPathToElasticSearchCertificate(): string
    {
        return $this->envData[self::PATH_TO_ELASTIC_CERTIFICATE];
    }

    public function getElasticPassword(): string
    {
        return $this->envData[self::ELASTIC_PASSWORD];
    }

    public function getPathToElasticBulkFile(): string
    {
        return $this->envData[self::PATH_TO_ELASTIC_BULK_FILE];
    }

    public function getElasticIndex(): string
    {
        return $this->envData[self::ELASTIC_INDEX];
    }
}