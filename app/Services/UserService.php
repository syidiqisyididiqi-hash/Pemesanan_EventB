<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function listUsers()
    {
        return User::with('role')->latest()->get();
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
        return $user->fresh();
    }

    public function deleteUser(User $user): bool
    {
        $user->delete();
        return true;
    }


}