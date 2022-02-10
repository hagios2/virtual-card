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

class AdminService
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
        if ($admin->is_active) {
            $admin->update(['is_active' => false]);

            return response()->json(['message' => 'deactivated']);
        }

        return response()->json(['message' => 'account already deactivated']);
    }

    public function unBlockAdmin(Admin $admin): JsonResponse
    {
        if (!$admin->is_active) {
            $admin->update(['is_active' => true]);

            return response()->json(['message' => 'activated']);
        }

        return response()->json(['message' => 'account already activated']);
    }
}
