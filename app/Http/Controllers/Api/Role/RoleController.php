<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
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
        return response()->json([
            'status' => true,
            'message' => 'Semua data role berhasil diambil',
            'data' => $this->roleService->listRoles()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole($request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Role berhasil dibuat',
            'data' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Data role berhasil diambil',
            'data' => $role
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $role = $this->roleService->updateRole($role, $request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Role berhasil diperbarui',
            'data' => $role
        ], 200);
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
