<?php

declare(strict_types=1);

class Validator
{
    private ?string $error = null;

    public function validate (Request $request): bool
    {
        if (!$request->isPost()) {
            $this->error = "Warning! POST method expected";
            return false;
        }

        $data = $request->getPostData();

        if (!isset($data['string'])) {
            $this->error = "Warning! 'string' parameter expected";
            return false;
        }

        if (empty($data['string'])) {
            $this->error = "Warning! 'string' parameter must not be empty";
            return false;
        }

        if (!preg_match("/^\([(,)]+$/", $data['string'])) {
            $this->error = "Warning! The string must start with an opening bracket and must contain only brackets";
            return false;
        }

        return true;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
