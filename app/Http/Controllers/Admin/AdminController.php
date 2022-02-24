<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminService)
    {
        $this->middleware(['auth:admin', 'role:admin,super admin']);
    }

    public function createAdmin(NewAdminRequest $request): JsonResponse
    {
        return $this->adminService->createAdmin($request);
    }

    public function fetchAdmins(): AnonymousResourceCollection
    {
        return $this->adminService->fetchAdmins();
    }

    #[Pure] public function fetchAnAdmin(Admin $admin): AdminResource
    {
        return $this->adminService->fetchAnAdmin($admin);
    }

    public function updateAdmin(Admin $admin, NewAdminRequest $request): JsonResponse
    {
        return $this->adminService->updateAdmin($admin, $request);
    }

    public function blockAdmin(Admin $admin): JsonResponse
    {
        return $this->adminService->blockAdmin($admin);
    }

    public function unBlockAdmin(Admin $admin): JsonResponse
    {
        return $this->adminService->unBlockAdmin($admin);
    }
}
