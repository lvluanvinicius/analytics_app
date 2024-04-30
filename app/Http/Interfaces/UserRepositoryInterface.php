<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;

    public function create(array $details): User;

    public function users(string | null $search, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator;
}
