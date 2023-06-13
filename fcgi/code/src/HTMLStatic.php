<?php

declare(strict_types=1);

namespace Otus\App;

class HTMLStatic
{
    public static function mainPage()
    {
        echo
            '<html>
                <head></head>
                <body>
                    <form action="/" method="POST">
                        <input type="text" name="text"/>
                        <button type="submit">Check</button>
                    </form>
                </body>
            </html>';
    }
    public static function correctPage()
    {
        echo
            '<html>
                <head></head>
                <body>
                    <a href="/">return to index page</a>
                    <br> The string is correct
                </body>
            </html>';
    }
}
