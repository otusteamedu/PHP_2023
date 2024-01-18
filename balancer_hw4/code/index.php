<?php

declare(strict_types=1);

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. Only POST is allowed.');
    }

    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (!isset($data['str'])) {
        throw new Exception('Invalid request: missing "str" parameter');
    }

    $str = $data['str'];

    if (empty($str)) {
        throw new Exception('Invalid string: empty input');
    }

    //func
    if ($str[0] === ")" || $str[mb_strlen($str) - 1] === "(") {
        return false;
    }
    $result = true;
    $smb_array = [];
    for($i = 0; $i < strlen($str); $i++){

        $smb = $str[$i];

        if($smb == "("){
            array_push($smb_array, '(');
        }elseif($smb == ")"){
            if(empty($smb_array)){
                $result = false;
                break;
            }
            array_pop($smb_array);
        }
    }


    if(empty($smb_array) && $result){
        http_response_code(200);
        echo 'Success: valid string';
    }else{
        http_response_code(200);
        echo $smb_array;
        echo 'NO valid string';
    }




} catch (Exception $e) {
    http_response_code(400);
    echo $e->getMessage();
}




?>