<?php

namespace Ndybnov\Hw04\hw;

class ParseString
{
    private ResultDTO $resultDTO;

    private function __construct() {
    }

    public static function build(): self {
        return new self();
    }

    public function makeResult(?string $str): ResultDTO {
//        if(!$str) {
//            return ResultDTO::build()
//                ->setString('NOT-EXIST')
//                ->setCodeStatus($checkedStatus)
//                ->setPositionDetectedError( $response['ind'] ?? -1 );
//        }

        $response = [];
        $checkedStatus = ParsingStr::build()->parse($str, $response);

        return ResultDTO::build()
            ->setString($str)
            ->setCodeStatus($checkedStatus)
            ->setPositionDetectedError( $response['ind'] ?? -1 );
    }
}
