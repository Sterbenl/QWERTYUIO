<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{

    public function rules()
    {
        return [
            'phone' => 'required|string|min:11',
            'password'=> 'required|string'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' =>[
                'status' => 'false',
                'message' => 'Invalid authorization data '
            ]
        ])->setStatusCode(401, 'Invalid authorization data')->header('Content-Type','application/json'));
    }
}
