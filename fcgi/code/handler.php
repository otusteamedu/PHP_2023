<a href="/index.html">return to index page</a>
<br>
<?php
if (empty($_POST["text"])) {
    http_response_code(400);
    throw new Exception('Empty value');
}
if (! check($_POST["text"])) {
    http_response_code(400);
    throw new Exception("Bracket error");
}
http_response_code(200);
echo "The string is correct";
function check($input) {
    $input = preg_replace('/[^(|)]/', "", $input);
    $repl = str_replace([")"],["(r"], $input);
    $result = preg_replace('/([(])(?R)*\1r/', "", $repl);
    return mb_strlen($result) == 0;
}
