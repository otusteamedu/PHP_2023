<?php

namespace IilyukDmitryi\App\Controllers;

use IilyukDmitryi\App\Form\Emails;
use IilyukDmitryi\App\Statistic\StatisticEngine;
use IilyukDmitryi\App\Validation\Validation;

class AppController
{
    /**
     * @var Validation[] $checkers
     */
    private array $checkers;
    private ?StatisticEngine $statisticEngine;
    private string $stringCheck = '';

    /**
     * @param StatisticEngine $statisticEngine
     */
    public function setStatisticEngine(StatisticEngine $statisticEngine): void
    {
        $this->statisticEngine = $statisticEngine;
    }

    public function checkEmails()
    {
        $emails = Emails::getPostEmails();
        if (!$emails) {
            return [];
        }

        $emailsData = $this->validationEmails($emails);
        $emailsData = $this->checkDomainMx($emailsData);
        $this->addStatisticResult($emailsData);
        return $emailsData;
    }

    public static function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }

    public function checkDomainMx(array $emailsData): array
    {
        $domainMxCheckers = new \Ilyukdim\OtusCheckers\Checkers();
        $checkDomainMx = new \Ilyukdim\OtusCheckers\Types\DomainMXRecords();
        $domainMxCheckers->addChecker($checkDomainMx);
        foreach ($emailsData as &$data) {
            if ($data['validation']) {
                $domain = $data['domain'];
                $res = $domainMxCheckers->check($domain);
                $data['domainMxRecords'] = $res;
            }
        }
        unset($data);
        return $emailsData;
    }

    public function validationEmails(array $emails): array
    {
        $validationEmailsResult = [];
        $checkersEmails = new \Ilyukdim\OtusCheckers\Checkers();
        $checkEmail = new \Ilyukdim\OtusCheckers\Types\EmailRegExp();
        $checkersEmails->addChecker($checkEmail);
        foreach ($emails as $email) {
            $email = trim($email);
            if (mb_strlen($email) > 5) {
                $res = $checkersEmails->check($email);
                $domain = $res ? static::getDomainFromEmail($email) : '';
                $validationEmailsResult[$email] = ['validation' => $res, 'domain' => $domain];
            }
        }

        return $validationEmailsResult;
    }

    private static function getDomainFromEmail(string $email): string
    {
        $domain = '';
        if ($email) {
            $domain = explode("@", $email)[1];
        }
        return $domain;
    }

    private function addStatisticResult($emailsData): void
    {
        $allEmailsGood = true;
        $stat = [];
        foreach ($emailsData as $email => $emailData) {
            if ($emailData['validation'] !== true || $emailData['domainMxRecords'] !== true) {
                $allEmailsGood = false;
            }
            $stat[] = $email . (($emailData['validation'] == true && $emailData['domainMxRecords'] == true) ? ' - good' : ' - fail');
        }

        if (!is_null($this->statisticEngine)) {
            $this->statisticEngine->addStat($allEmailsGood, implode('<br>', $stat));
        }
    }

    public function printStatisticResult(): void
    {
        if (!is_null($this->statisticEngine)) {
            $this->statisticEngine->printStat();
        }
    }

    public function showForm()
    {
        Emails::showForm();
    }
}
