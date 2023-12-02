<?php

declare(strict_types=1);

namespace Dshevchenko\Emailchecker\Controllers;

use Dshevchenko\Emailchecker\Checker;
use Dshevchenko\Emailchecker\Common;

class DefaultController
{
    /**
     * Отображает представление по умолчанию.
     *
     * @return void
     */
    public function render()
    {
        ob_start();
        include __DIR__ . '/../Views/DefaultView.php';
        echo ob_get_clean();
    }

    /**
     * Проверяет список электронных адресов из POST параметра на валидность.
     *
     * @return void
     */
    public function check()
    {
        $checker = new Checker();

        $rawEmails = $_POST['email_list'];
        $arrEmails = Common::explode($rawEmails);
        
        foreach ($arrEmails as $email) {
            if ($checker->check($email)) {
                echo "The email is valid: '$email'<br>";
            } else {
                echo "The email is invalid: '$email' (" . $checker->getLastDescription() . ')<br>';
            }
        }
    }
}
