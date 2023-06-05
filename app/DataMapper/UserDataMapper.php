<?php
declare(strict_types=1);

namespace App\DataMapper;

use App\Models\User;

class UserDataMapper extends BaseDataMapper {
    public function fetchAllUsers() {
        $sql = "SELECT * FROM users";
        $rows = $this->fetchAll($sql);

        $users = [];
        foreach($rows as $row) {
            $users[] = new User($row['id'], $row['name'], $row['email']);
        }

        return $users;
    }
}