<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class RoleService
{
    public function createRole(array $data): Role
    {
        return Role::create($data);
    }

    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return $role->delete();
    }

    public function listRoles(): LengthAwarePaginator
    {
        return Role::query()
            ->latest()
            ->paginate(10);
    }
}