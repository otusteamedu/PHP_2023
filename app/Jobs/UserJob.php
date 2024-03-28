<?php

namespace App\Jobs;

use App\Models\User;
use Exception;

class UserJob extends Job
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            $this->updateStatus(User::STATUS_COMPLETED);
        } catch (Exception) {
            $this->updateStatus(User::STATUS_FAILED);
        }
    }

    private function updateStatus(string $status): void
    {
        $this->user->status = $status;
        $this->user->save();
    }
}
