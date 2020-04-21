<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the profile.
     */
    public function update(User $signedIn, User $user)
    {
        return $signedIn->id === $user->id;
    }
}
