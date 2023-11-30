<?php

namespace DimAl\Homework5\Application;

use Exception;
use DimAl\Homework5\Services\EmailCheckService;
use DimAl\Homework5\Presentation\EmailStatusHtmlView;

class App
{
    public function run()
    {
        $check_list = $this->checkEmailsFromFile();

        $view = new EmailStatusHtmlView();
        $view->setTableTitle(
            [
                'email' => 'Email',
                'status' => 'Статус проверки'
            ]
        );

        $view->setRows($check_list);
        $view->show();
    }

    public function checkEmailsFromFile(): array
    {
        $ret = [];
        $emls = file(EMAIL_LIST_PATH);
        foreach ($emls as $eml) {
            $eml = trim($eml);
            $check_result = $this->emailIsWrong($eml);
            array_push(
                $ret,
                [
                    'email' => $eml,
                    'status' => $check_result ? $check_result : 'OK'
                ]
            );
        }
        return $ret;
    }

    public function emailIsWrong($email)
    {
        $checker = new EmailCheckService();

        try {
            if (!$checker->checkEmailFormat($email)) {
                throw new Exception("wrong email format");
            }

            if (!$checker->checkEmailMxDomain($email)) {
                throw new Exception("wrong mx domain");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return false;
    }
}
