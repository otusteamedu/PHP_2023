<?php

namespace Sva\Email;

class FromInput
{
    /**
     * @param string $separator
     * @return array
     */
    public function validate(string $separator = ','): array
    {
        $validator = new Validator();

        $input = file_get_contents('php://input');
        $input = htmlspecialchars($input);
        $emails = explode($separator, $input);

        $result = [];
        foreach ($emails as $key => $email) {
            $email = trim($email);
            $result[$email] = $validator->validate($email);
        };

        return $result;
    }
}