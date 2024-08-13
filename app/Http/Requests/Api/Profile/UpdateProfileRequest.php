<?php

namespace App\Http\Requests\Api\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array(User::rules(), [
            'email' => 'required|email:filter|unique:users,email,' . auth()->user()->id,
            'phone' => 'required|string|max:50|unique:users,phone,' . auth()->user()->id,
            'password' => 'nullable|string|min:8|max:32|confirmed',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
        ]);
    }
}
