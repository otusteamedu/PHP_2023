<?php

namespace Daniel\Pattern;

class App {
    private UserDataMapper $userDataMapper;

    public function __construct(
    ) {
        $dbConnection = new DatabaseConnection();
        $pdo = $dbConnection->connect();

        $identityMap = new IdentityMap();
        $this->userDataMapper = new UserDataMapper($pdo, $identityMap);
    }

    public function run(): array {
        return $this->userDataMapper->findAll();
    }
}
