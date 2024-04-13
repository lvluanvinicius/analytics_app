<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;

    public function create(array $details): User;
}