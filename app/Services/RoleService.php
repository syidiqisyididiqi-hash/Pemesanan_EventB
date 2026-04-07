<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleService
{
    public function createRole(array $data): Role
    {
        $allowed = Arr::only($data, [
            'name',
            'description',
        ]);

        return Role::create($allowed);
    }

    public function updateRole(Role $role, array $data): Role
    {
        $allowed = Arr::only($data, [
            'name',
            'description',
        ]);

        $role->update($allowed);

        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return $role->delete();
    }

    public function listRoles(int $perPage = 10): LengthAwarePaginator
    {
        return Role::latest()->paginate($perPage);
    }

    public function findRoleOrFail(int $id): Role
    {
        return Role::findOrFail($id);
    }
}