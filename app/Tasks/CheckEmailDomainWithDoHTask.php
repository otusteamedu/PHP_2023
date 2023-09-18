<?php

namespace Rofflexor\Hw\Tasks;

use Exception;

class CheckEmailDomainWithDoHTask
{

    protected array $defaultServers = [
        'Quad9 Foundation' => 'https://dns.quad9.net:5053/dns-query',
        'Cloudflare for Teams' => 'https://security.cloudflare-dns.com/dns-query',
        'Cloudflare' => 'https://cloudflare-dns.com/dns-query',
        'Google' => 'https://dns.google/resolve',
    ];

    /**
     * @throws Exception
     */
    public function run(string $email): bool
    {
        $domain = explode('@', $email)[1];

        foreach ($this->defaultServers as $serverName => $urlPrefix) {
            $url = "$urlPrefix?name={$domain}&type=MX";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['accept: application/dns-json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($result === false || $httpCode !== 200) {
                continue;
            }

            $json = json_decode($result, false, 512, JSON_THROW_ON_ERROR);

            if (json_last_error() !== JSON_ERROR_NONE) {
                continue;
            }

            if ($json->Status === 5) {
                return false;
            }

            if ($json->Status !== 0) {
                return false;
            }

            if (!isset($json->Answer) || (isset($json->Answer[0]) && $json->Answer[0]->data === '0.0.0.0')) {
                return false;
            }
            return true;
        }

        throw new \RuntimeException("The DNS queries to all servers failed while validating domain of email: {$email}. Not sure what's happening but it's likely a problem on our side.");

    }

}