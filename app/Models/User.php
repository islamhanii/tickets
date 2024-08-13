<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /*----------------------------------------------------------------------------------------------------*/

    public function imageLink(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image ? env('APP_URL') . "/uploads/$this->image" : ("https://ui-avatars.com/api/?name=" . explode(' ', trim($this->name))[0] . ".png"),
        );
    }

    /*----------------------------------------------------------------------------------------------------*/

    public static function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'email' => 'required|email:filter|max:250|unique:users',
            'phone' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:8|max:32|confirmed',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
        ];
    }
}
