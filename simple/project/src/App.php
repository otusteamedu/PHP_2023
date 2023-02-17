<?php

declare(strict_types=1);

namespace src;

class App
{
    private Request $request;
    private Validator $validator;

    public function __construct(Request $request, Validator $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    /**
     * @throws BadRequestException
     */
    public function run(): string
    {
        if (!$this->validator->validate($this->request)) {
            throw new BadRequestException($this->validator->getError());
        }

        $data = $this->request->getPostData();

        if (!$this->checkBrackets($data['string'])) {
            throw new BadRequestException('Warning! Bracket sequence is not valid');
        }

        return 'OK! Bracket sequence is valid';
    }

    private function checkBrackets(string $string): bool
    {
        $brackets = str_split($string);

        $counter = 0;

        foreach ($brackets as $bracket) {

            if ($bracket == '(') {
                $counter++;
            }

            if ($bracket == ')') {
                $counter--;
            }

            if ($counter < 0) {
                return false;
            }
        }

        if ($counter !== 0) {
            return false;
        }

        return true;
    }
}
