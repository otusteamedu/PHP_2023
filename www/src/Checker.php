<?php

declare(strict_types=1);

namespace Singurix\Emailscheck;

class Checker
{
    private array $emails;

    public function start(): void
    {
        if($_POST) {
            $emails = $_POST['emails'];
            $this->emails = $this->textToArray(trim($emails));
            echo json_encode($this->check());
        }else{
            require_once($_SERVER['DOCUMENT_ROOT'] . '/view.php');
        }
    }

    public function check(): array
    {
        $result = [];
        foreach ($this->emails as $email) {
            $email = str_replace("\r", "", $email);
            $result[$email] = Validator::check(trim($email));
        }
        return $result;
    }

    private function textToArray(string $emails): array
    {
        return explode(PHP_EOL, $emails);
    }
}
