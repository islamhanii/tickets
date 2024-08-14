<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageStorage;

class ProfileController extends Controller
{
    use ApiResponse, ImageStorage;

    public function profile()
    {
        return $this->apiResponse(200, __("messages.profile"), null, new UserResource(auth()->user()));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $this->uploadImage($request, 'users', $user),
        ]);

        return $this->apiResponse(200, __("messages.profile_updated"), null, new UserResource($user));
    }
}
