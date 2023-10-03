<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Models\User;
use Generator;

class UserDataMapper extends BaseDataMapper
{
    public function fetchAllUsers(): Generator
    {
        $rows = $this->database->selectAll('users');

        foreach ($rows as $row) {
            yield new User($row['id'], $row['name'], $row['email']);
        }
    }
}