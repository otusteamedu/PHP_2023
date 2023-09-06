<?php

namespace Nalofree\Hw5;

use DOMDocument;

class IndexController
{
    public function __construct()
    {
    }

    public function check($request, $response): void
    {
        $string = $request->getPostParam('string');
        $document = new DOMDocument(); // Решил не запариваться шаблонизатором и закономерно хапнул ешё проблемок.
        $document->loadHTMLFile($_SERVER['DOCUMENT_ROOT'] . "/views/form.php");
        $document->getElementById('email-list')->textContent = $string;
        $checker = new EmailChecker($string);
        $checked_emails = $checker->check();
        $valid_isset = array_search("valid", $checked_emails, true);
        if (empty($checked_emails)) {
            $response->setStatusCode(400);
            $response->setStatusText("Текст, что всё плохо");
            $response->setBody("Нет ни одной годного емейла");
        } else {
            $response->setStatusCode($valid_isset ? 200 : 400);// Если хотябы один мейл ок, то 200. Если нет, то 400.
            $response->setStatusText($valid_isset ? "Текст, что всё хорошо" : "Текст, что всё плохо");
            $checked_emails_json = json_encode($checked_emails);
            $response->setBody($document->saveHTML() . "</br>Годные емейлы: <pre>$checked_emails_json</pre>");
        }
    }

    public function index($request, $response): void
    {
        $document = new DOMDocument();
        $document->loadHTMLFile($_SERVER['DOCUMENT_ROOT'] . "/views/form.php");
        $response->setStatusCode(200);
        $response->setStatusText("Текст, что всё хорошо");
        $response->setBody($document->saveHTML());
    }
}
