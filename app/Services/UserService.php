<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function listUsers(): LengthAwarePaginator
    {
        return User::with('role')
            ->latest()
            ->paginate(10);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}