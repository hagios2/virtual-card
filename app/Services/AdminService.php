<?php

namespace App\Services;

use App\Http\Requests\NewAdminRequest;
use App\Http\Resources\AdminResource;
use App\Mail\NewAminMail;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class AdminService extends ManageAccountService
{
    public function createAdmin(NewAdminRequest $request): JsonResponse
    {
        $adminData = $request->except('role');

        $password = Str::random(8);

        $adminData['password'] = bcrypt($password);

        $admin = Admin::create($adminData);

        $admin->assignRole($request->safe()->role);

        Mail::to($admin)->queue(new NewAminMail($admin, $password));

        return response()->json(['message' => 'admin created', 'admin' => new AdminResource($admin)], 201);
    }

    public function fetchAdmins(): AnonymousResourceCollection
    {
        return AdminResource::collection(Admin::query()->latest()->get());
    }

    #[Pure] public function fetchAnAdmin(Admin $admin): AdminResource
    {
        return new AdminResource($admin);
    }

    public function updateAdmin(Admin $admin, NewAdminRequest $request): JsonResponse
    {
        $admin->update($request->validated());

        return response()->json(['message' => 'admin updated', 'admin' => new AdminResource($admin)]);
    }

    public function blockAdmin(Admin $admin): JsonResponse
    {
        return $this->blockAccount($admin);
    }

    public function unBlockAdmin(Admin $admin): JsonResponse
    {
        return $this->unBlockAccount($admin);
    }
}
