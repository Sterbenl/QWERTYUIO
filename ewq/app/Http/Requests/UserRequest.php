<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|min:11',
            'password' => 'required|string|min:4',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errs = [];
        foreach($validator->errors()->keys() as $key) {
            $errs[$key] = $validator->errors()->first($key);
        }
        throw new HttpResponseException(response()->json([
            'error' =>[
                'status' => 'false',
                'message' => $errs
            ]
        ])->setStatusCode(422, 'Unprocessable entity'));
    }
}
