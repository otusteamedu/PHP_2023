<?php

declare(strict_types=1);

namespace Otus\App;

class HTMLStatic
{
    static public function mainPage() {
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
    static public function correctPage() {
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
