<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\emails;

use NdybnovHw03\CnfRead\ConfigStorage;

class ExternalDnsMxValidateRule implements ValidateRuleInterface
{
    private string $hostDockerNginx;

    public function __construct()
    {
        $pathToConfigFile = dirname(__DIR__);
        $configStorage = (new ConfigStorage())
            ->fromDotEnvFile([$pathToConfigFile, 'config.ini']);

        $this->hostDockerNginx = $configStorage->get('nginx-docker-host');
    }

    public function validate(string $email): bool
    {
        try {
            $curl = \curl_init();

            $url = $this->hostDockerNginx . '/?email=' . $email;
            \curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = \curl_exec($curl);

            \curl_close($curl);

            $info = \json_decode($response, true, 512, JSON_THROW_ON_ERROR) ['info'] ?? '';

            return ('ok' === $info);
        } catch (\Exception $exception) {
            throw new $exception($exception->getMessage());
        }
    }
}
