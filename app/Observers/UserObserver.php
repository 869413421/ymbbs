<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function saving(User $user)
    {
        if (empty($user->head_img)) {
            $user->head_img = 'https://iocaffcdn.phphub.org/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    }
}