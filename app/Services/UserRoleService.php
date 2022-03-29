<?php

namespace App\Services;

use App\Models\UserRole;
use App\Models\User;

class UserRoleService
{
    protected $model;

    public function __construct(UserRole $model)
    {
        $this->model = $model;
    }

    public function setRole(User $user, int $role = 2)
    {
        $this->model->create([
            'user_id' => $user->id,
            'role' => $role
        ]);
    }
}
