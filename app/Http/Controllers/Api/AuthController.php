<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\SignupRequest;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageStorage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse, ImageStorage;

    public function login(LoginRequest $request)
    {
        $user = User::where([['email', $request->email]])->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken("auth-token");

            return $this->apiResponse(200, __('messages.logged_successfully'), null, [
                'access_token' => "Bearer $token->plainTextToken",
            ]);
        }

        return $this->apiResponse(400, __('messages.login_failed'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function signup(SignupRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "image" => $this->uploadImage($request, 'users'),
        ]);

        $token = $user->createToken("auth-token");

        return $this->apiResponse(200, __('messages.signup_successfully'), null, [
            'access_token' => $token->plainTextToken,
        ]);
    }
}
