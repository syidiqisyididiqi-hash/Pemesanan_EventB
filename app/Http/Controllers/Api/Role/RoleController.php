<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles = Role::all();

        return response()->json([
            'message' => 'Roles retrieved successfully',
            'data' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole($request->validated());

        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json([
            'message' => 'Role retrieved successfully',
            'data' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $updated = $this->roleService->updateRole($role, $request->validated());

        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->roleService->deleteRole($role);

        return response()->json(null, 204);
    }
}
