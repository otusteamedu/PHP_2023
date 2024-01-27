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

    public function run(int $page = 1, int $pageSize = 10): array {
        return $this->userDataMapper->findAll($page, $pageSize);
    }
}
