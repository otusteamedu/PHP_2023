<?php

/**
 * Класс для объединения логики обработки скобок и представления
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\applications\email_and_brackets\presenters;

use Amedvedev\code\applications\email_and_brackets\helpers\BracketsHelper;

class BracketsHandlerPresenter
{
    public function render(array $post)
    {
        if (empty($post)) {
            return '';
        }
        $bracketsHelper = new BracketsHelper();
        $string = $post['string'] ?? '';

        $result = $bracketsHelper->handle($post);
        if (!$result) {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }

        $color = $result ? 'green' : 'red';
        $not = $result ? '' : 'не';

        return str_replace(
            [
                '{color}',
                '{string}',
                '{not}'
            ],
            [
                $color,
                $string,
                $not
            ],
            file_get_contents(__DIR__ . '/../views/brackets.php')
        );
    }
}
