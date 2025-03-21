<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class Me
{
    public static function getUser(Authenticatable|int $user): User
    {
        if ($user instanceof User) {
            return $user;
        }

        if ($user instanceof Authenticatable) {
            return User::find($user->getAuthIdentifier());
        }

        return User::find($user);
    }
}
