<?php

namespace Sva\Email;

use Exception;
use Generator;

class FromFile
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * @param string $filePath
     * @return array
     * @throws Exception
     */
    public function validate(string $filePath): array
    {
        $result = [];

        if (file_exists($filePath)) {
            $lines = $this->getLines($filePath);

            foreach ($lines as $key => $line) {
                $line = htmlspecialchars($line);
                $result[$line] = $this->validator->validate($line);
            }

            return $result;
        } else {
            throw new Exception('File \'' . $filePath . '\' not found');
        }
    }

    /**
     * @param $file
     * @return Generator
     */
    private function getLines($file): Generator
    {
        $f = fopen($file, 'r');
        try {
            while ($line = fgets($f)) {
                yield trim($line);
            }
        } finally {
            fclose($f);
        }
    }
}
