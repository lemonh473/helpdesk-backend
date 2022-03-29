<?php

namespace App\Services;

use App\Models\User;
use App\Services\UserRoleService;

class UserService
{
    protected $model;
    protected $userRoleService;

    public function __construct(User $model, UserRoleService $userRoleService)
    {
        $this->model = $model;
        $this->userRoleService = $userRoleService;
    }

    private function processPayload(array $payload): array
    {
        $payload['password'] = bcrypt($payload['password']);

        return $payload;
    }

    public function create(array $payload) 
    {
        $payload = $this->processPayload($payload);

        $user = $this->model->create($payload);

        $this->afterSave($user);
    }

    private function afterSave(User $user)
    {
        $this->userRoleService->setRole($user);
    }
}
