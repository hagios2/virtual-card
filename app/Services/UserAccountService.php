<?php

namespace App\Services;

use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AuthUserResource;
use App\Mail\ResendVerificationLinkMail;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAccountService
{
    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        $userData = $request->safe()->except('password');

        $userData['password'] = bcrypt($request->safe()->password);

        $userData['is_active'] = false;

        $user = User::create($userData);

        $verificationToken = Hash::make($user->email);

        Mail::to($user)->queue(new UserRegistrationMail($user, $verificationToken));

        return response()->json(['message' => 'user created', 'user' => new AuthUserResource($user)], 201);
    }

    public function updateUser(User $user, UserRegistrationRequest $request): JsonResponse
    {
        $user->update($request->safe()->except('password'));

        return response()->json(['message' => 'account updated']);
    }

    public function verifyEmail(EmailVerificationRequest $request): JsonResponse
    {
       $data = $request->validated();
       if (Hash::check($data['email'], $data['token'])) {
           User::query()
               ->where('email', $data['email'])
               ->update(['email_verified_at' => now()]);

           return response()->json(['message' => 'email verified']);
       }
        return response()->json(['message' => 'Invalid Email or Token'], 422);
    }

    public function resendVerificationLink(): JsonResponse
    {
        $verificationToken = Hash::make(auth()->user()->email);

        $user = User::find(auth()->id());

        Mail::to(auth()->user())->queue(new ResendVerificationLinkMail($user, $verificationToken));

        return response()->json(['message' => 'mail sent']);
    }
}
