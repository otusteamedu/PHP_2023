<?php

require_once './app/Services/TextEmailValidatorService.php';

$multilineTextCorrect = <<<EMAILTEXT
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do test@kidsbrandstore.se incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis@afilias.info exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat@cambridge.education, sunt in culpa qui officia cil-lum@dolore.eu deserunt mollit anim id est laborum.
EMAILTEXT;

$multilineText = <<<EMAILTEXT
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius.mod@tempor.se incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis@nostrud.123 exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cil-lum@dolore.eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat@non.proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
EMAILTEXT;

$arrayOfStrings = [
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius.mod@tempor.se incididunt ut labore et dolore magna aliqua.',
    'Ut enim ad minim veniam, quis@nostrud.info exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'Duis aute irure dolor in reprehenderit in voluptate velit esse cil-lum@dolore.eu fugiat nulla pariatur.',
    'Excepteur sint occaecat cupidatat@non.proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
];

function showResponse(array $result, \app\Services\TextEmailValidatorService $textEmailValidator): void
{
    if (count($result[$textEmailValidator::PARAM_ALL_EMAILS]) > 0) {
        echo nl2br('The provided text contains the following list of email addresses:' . PHP_EOL
            . implode(PHP_EOL, $result[$textEmailValidator::PARAM_ALL_EMAILS]) . PHP_EOL . PHP_EOL);
    }

    if ($result[$textEmailValidator::PARAM_RESPONSE] === $textEmailValidator::STATUS_SUCCESS) {
        echo 'All email addresses in the text are valid and its domains have DNS MX records.';
    } else {
        echo nl2br(isset($result[$textEmailValidator::PARAM_INVALID_EMAILS])
            ? 'The following list contains invalid email addresses:' . PHP_EOL
            . implode(PHP_EOL, $result[$textEmailValidator::PARAM_INVALID_EMAILS]) . PHP_EOL
            : '');
        echo nl2br(isset($result[$textEmailValidator::PARAM_EMAILS_WITHOUT_MX])
            ? 'The following list contains email addresses that domains don\'t have DNS MX record(s):' . PHP_EOL
            . implode(PHP_EOL, $result[$textEmailValidator::PARAM_EMAILS_WITHOUT_MX])
            : '');
    }
}

$textEmailValidator = new \app\Services\TextEmailValidatorService();

$validateMultilineTextCorrect = $textEmailValidator->validate($multilineTextCorrect);
showResponse($validateMultilineTextCorrect, $textEmailValidator);

echo nl2br(PHP_EOL . PHP_EOL . PHP_EOL);

$validateMultilineText = $textEmailValidator->validate($multilineText);
showResponse($validateMultilineText, $textEmailValidator);

echo nl2br(PHP_EOL . PHP_EOL . PHP_EOL);

$validateArrayOfStrings = $textEmailValidator->validate($arrayOfStrings);
showResponse($validateArrayOfStrings, $textEmailValidator);
