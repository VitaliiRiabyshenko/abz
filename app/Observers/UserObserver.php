<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Token;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function saved(User $user): void
    {
        $token = request()->bearerToken();

        Token::where('token', $token)->update([
            'used' => 1
        ]);
    }
}
