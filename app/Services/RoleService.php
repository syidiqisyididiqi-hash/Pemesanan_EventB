<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

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

    public function listRoles(): Collection
    {
        return Role::query()
            ->latest()
            ->get();
    }
}