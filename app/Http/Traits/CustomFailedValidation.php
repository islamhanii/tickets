<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait CustomFailedValidation
{
    protected function failedValidation(Validator $validator)
    {
        $response = $this->apiResponse(400, $this->getFirstError($validator));

        throw new HttpResponseException($response);
    }
}