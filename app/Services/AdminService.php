<?php

namespace App\Services;

use App\Http\Requests\NewAdminRequest;
use App\Http\Resources\AdminResource;
use App\Mail\NewAminMail;
use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class AdminService extends ManageAccountService
{
    public function createAdmin(NewAdminRequest $request): JsonResponse
    {
        $adminData = $request->validated();

        $password = Str::random(8);

        $adminData['password'] = bcrypt($password);

        $admin = Admin::create($adminData);

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

    public function blockAdmin(Admin $admin): JsonResponse
    {
        return $this->blockAccount($admin);
    }

    public function unBlockAdmin(Admin $admin): JsonResponse
    {
        return $this->unBlockAccount($admin);
    }

    public function blockAgency(Agency $agency): JsonResponse
    {
        return $this->blockAccount($agency);
    }

    public function unBlockAgency(Agency $agency): JsonResponse
    {
        return $this->unBlockAccount($agency);
    }
}
