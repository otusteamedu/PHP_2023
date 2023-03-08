<?php

function response(): string
{
    if (empty($_REQUEST['emails'])) {
        http_response_code('400');
        return "Empty emails";
    }

    $arr_emails = explode(', ', $_REQUEST['emails']);
    $emails = getValidEmails($arr_emails);
    if (!$emails->valid()) {
        http_response_code('400');
        return 'No valid emails';
    }

    http_response_code('200');

    return getResultFromGenerator($emails);
}
