<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /*----------------------------------------------------------------------------------------------------*/

    public static function rules()
    {
        return [
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:5000',
        ];
    }
}
