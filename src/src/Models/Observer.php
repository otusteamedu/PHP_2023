<?php

namespace App\Models;

interface Observer
{
    public function update(string $status);
}
