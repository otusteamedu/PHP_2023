<?php

namespace src\factory;

use src\interface\CreatorServiceInterface;

class FactoryCreatorService {
    public static function create(): CreatorServiceInterface {
        return new CreatorService();
    }
}
