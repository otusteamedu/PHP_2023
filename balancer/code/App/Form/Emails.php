<?php

namespace IilyukDmitryi\App\Form;

class Emails
{
    public static function showForm(): void
    {
        $emails = static::isPost() ? (implode("\n", static::getPostEmails())) : "";
        View::show($emails);
    }

    private static function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }

    public static function getPostEmails(): array
    {
        $emails = [];
        if (static::isPost()) {
            $emails = array_map(function ($line) {
                return trim(htmlspecialchars($line));
            }, explode("\n", $_POST['emails']));
        }
        return $emails;
    }
}
