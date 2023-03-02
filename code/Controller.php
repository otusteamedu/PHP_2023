<?php
declare(strict_types=1);

use Exceptions\InvalidCountException;
use Exceptions\NotAStringException;
use Exceptions\NotClosedExcaption;
use Validator\Validator;

class Controller
{
    public function stringBalance(): void
    {
        $validator = new Validator($_POST['string']);

        try {
            $validator->validate();
        } catch (InvalidCountException $e) {
            http_response_code(400);
            echo "Error: The number of opening and closing parentheses do not match.";
            exit;
        } catch (NotClosedExcaption $e) {
            http_response_code(400);
            echo "Error: The parentheses are not correctly balanced.";
            exit;
        } catch (NotAStringException $e) {
            http_response_code(400);
            echo "Error: Invalid input.";
            exit;
        } finally {
            // If everything is fine, return 200 OK response
            http_response_code(200);
            echo "The string has correctly balanced parentheses.";
        }
    }
}
