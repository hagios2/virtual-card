<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthAgentResource;
use App\Interfaces\LoginInterface;
use App\Models\Agent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgencyAuthService extends AuthService implements LoginInterface
{
    public function guardLogin(LoginRequest $request, string $guard = 'api'): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['is_active'] = true;

        if (! $token = auth()->guard($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $tokenResponse = $this->respondWithToken($token, $guard);

        $tokenResponse['user'] = $this->getAuthResource($guard);

        $this->VerifyAndUpdateUserFields();

        return response()->json($tokenResponse);
    }

    public function authUser(): AuthAgentResource
    {
        return $this->getAuthResource('agent');
    }

    public function getAuthResource(string $guard = 'api'): AuthAgentResource
    {
        return new AuthAgentResource(auth()->guard($guard)->user());
    }

    # this will automatically verify users registered by admin
    # the first time they log in and also update last login field
    public function VerifyAndUpdateUserFields()
    {
        if (auth()->user()->registered_by_admin && !auth()->user()->email_verified_at) {
            auth()->user()->update([
                'email_verified_at' => now(),
                'last_login' => now()
            ]);
        } else {
            auth()->user()->update(['last_login' => now()]);
        }
    }

    public function logout(): JsonResponse
    {
        return $this->guardLogout('agent');
    }

    public function refresh(): JsonResponse
    {
        return $this->guardRefresh('agent');
    }

    public function changePassword(ChangePasswordRequest $request,): JsonResponse
    {
        return $this->changeUserPassword($request, 'agent');
    }

    public function sendResetRequest(Request $request): JsonResponse
    {
        $request->validate(['email' => 'bail|required|email']);

        $client = Agent::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'agent');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->reset($request, 'agent');
    }
}
