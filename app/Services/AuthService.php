<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use App\Interfaces\AuthServiceInterface;
use App\Mail\AdminPasswordRequestMail;
use App\Mail\AgencyPasswordRequestMail;
use App\Mail\UserPasswordRequestMail;
use App\Models\Admin;
use App\Models\Agency;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService implements AuthServiceInterface
{
    public function guardLogin(string $guard = 'api'): JsonResponseAlias
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenResponse = $this->respondWithToken($token, $guard);

        $tokenResponse['user'] = $this->getAuthResource($guard);

        return response()->json($tokenResponse);
    }

    public function guardLogout(string $guard = 'api'): JsonResponseAlias
    {
        auth()->guard($guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function guardRefresh(string $guard = 'api'): JsonResponseAlias
    {
        return response()->json($this->respondWithToken(auth()->guard($guard)->refresh(), $guard));
    }

    public function respondWithToken($token, string $guard): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
    }

    public function getAuthResource(string $guard = 'api'): AuthAgencyResource|AdminResource|AuthUserResource
    {
        return match ($guard) {
            'api' => new AuthUserResource(auth()->user()),
            'admin' => new AdminResource(auth()->guard($guard)->user()),
            'agency' => new AuthAgencyResource(auth()->guard($guard)->user())
        };
    }

    public function changeUserPassword(ChangePasswordRequest $request, string $guard = 'api'): JsonResponse
    {
        $client = auth()->guard($guard)->user();

        if ($request->first_time) {
            $client->update([
                'password' => Hash::make($request->safe()->new_password),
                'must_change_password' => false
            ]);
            return response()->json(['message' => 'password changed']);
        } else {
            if (Hash::check($request->password, $client->password)) {
                if ($request->password == $request->new_password) {
                    return response()->json(['message' => 'Password is already in use']);
                } else {
                    $client->update(['password' => Hash::make($request->new_password)]);
                    return response()->json(['message' => 'password changed']);
                }
            }
            return response()->json(['message' => 'invalid Password']);
        }
    }

    public function sendResetMail($client, string $account_type): JsonResponse
    {
        if ($client) {
            $generated_token = Str::random(70);

            $passwordReset = PasswordReset::create([
                'email' => $client->email,
                'token' => $generated_token,
                'account_type' => $account_type
            ]);

            $mail = match ($account_type) {
                'admin' => new AdminPasswordRequestMail($client, $passwordReset),
                'user' => new UserPasswordRequestMail($client, $passwordReset),
                'agency' => new AgencyPasswordRequestMail($client, $passwordReset),
            };

            Mail::to($client)->queue($mail);

            return response()->json(['message' => 'Email sent']);
        }
        return response()->json(['message' => 'Email not found'], 404);
    }

    public function reset(ResetPasswordRequest $request, string $account_type): JsonResponse
    {
        $resetData = $request->validated();

        $passwordReset = PasswordReset::query()->where([['token', $resetData['token']], ['account_type', $account_type]])->first();

        if ($passwordReset) {
            if ($passwordReset->has_expired || Carbon::parse($passwordReset->created_at)->addMinutes(30)->lessThan(now())) {
                $passwordReset->update(['has_expired' => true]);
                return response()->json(['message' => 'Operation Aborted! Token has Expired'], 403);
            }
            $client = match ($account_type) {
                'admin' => Admin::where('email', $passwordReset->email)->first(),
                'user' => User::where('email', $passwordReset->email)->first(),
                'agency' => Agency::where('email', $passwordReset->email)->first()
            };

            $client->update(['password' => Hash::make($resetData['password'])]);

            $passwordReset->update(['has_expired' => true]);

            return response()->json(['message' => 'new password saved']);
        }
        return response()->json(['message' => 'Token not found']);
    }
}
