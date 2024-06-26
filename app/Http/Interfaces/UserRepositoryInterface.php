<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function users(array $params, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator;

    public function findByUsername(string $username): ?User;

    public function create(array $details): User;

    public function update(array $attr, string $userid): User;

    public function destroy(string $userid): bool;
}
