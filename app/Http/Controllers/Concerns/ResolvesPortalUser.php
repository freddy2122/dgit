<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;

trait ResolvesPortalUser
{
    protected function portalUser(): User
    {
        /** @var User $user */
        $user = auth()->user();

        return $user;
    }
}
