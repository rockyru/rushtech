<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\ApiUserServiceInterface;

class ApiUserService implements ApiUserServiceInterface
{
    public function getProfile(): array
    {
        return User::with(['roles', 'permissions'])->findOrFail(auth()->user()->id)->toArray();
    }

}