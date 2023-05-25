<?php

if ($_REQUEST) {
    if (isset($_POST['string'])) {
        $string = $_POST['string'];
        if (empty($string)) {
            header('HTTP/1.1 400 Bad Request');
            header('Response: Parameter "string" is empty.');
            echo 'Parameter "string" is empty.';
        }

        $justBracesString = '';
        foreach (str_split($string) as $symbol) {
            if (in_array($symbol, ['(', ')'])) {
                $justBracesString .= $symbol;
            }
        }

        while (strpos($justBracesString, '()') !== false) {
            $justBracesString = str_replace('()', '', $justBracesString);
        }

        if (strlen($justBracesString) > 0) {
            header('HTTP/1.1 400 Bad Request');
            header('Response: Incorrect string - braces are not paired.');
            echo 'Incorrect string - braces are not paired.';
        } else {
            header('HTTP/1.1 200 OK');
            header('Response: Everything is fine.');
            echo 'Everything is fine.';
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        header('Response: Parameter "string" is missing.');
        echo 'Parameter "string" is missing.';
    }
} else { ?>
    <html lang="en">
    <head>
        <title>Test</title>
    </head>
    <body>
    <form method="post">
        <input type="text" name="string" />
        <button>Submit</button>
    </form>
    </body>
    </html>
<?php }
