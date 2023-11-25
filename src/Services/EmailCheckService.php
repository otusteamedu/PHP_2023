<?php

namespace DimAl\Homework5\Services;

class EmailCheckService
{
    public function checkEmailFormat($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function checkEmailMxDomain($email): bool
    {
        if (count(explode("@", $email)) != 2) {
            return false;
        }

        $domain = explode('@', $email)[1];

        if (!filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return false;
        }

        $mx = $this->getMxDomain($domain);

        if (!count($mx)) {
            return false;
        }

        return true;
    }

    private function getMxDomain($domain): array
    {
        $mx_srvrs = [];

        $mx_records = dns_get_record($domain, DNS_MX);
        if ($mx_records) {
            foreach ($mx_records as $rec) {
                array_push($mx_srvrs, $rec['target']);
            }
        }

        return $mx_srvrs;
    }
}
