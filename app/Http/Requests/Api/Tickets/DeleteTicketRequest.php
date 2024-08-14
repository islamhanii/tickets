<?php

namespace App\Http\Requests\Api\Tickets;

use App\Http\Traits\ApiResponse;
use App\Http\Traits\CustomFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class DeleteTicketRequest extends FormRequest
{
    use ApiResponse, CustomFailedValidation;

    protected $stopOnFirstFailure = true;
    
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
        return [
            'ticket_id' => 'required|exists:tickets,id',
        ];
    }
}
