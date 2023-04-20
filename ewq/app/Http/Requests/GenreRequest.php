<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GenreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string'
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
        ])->setStatusCode(422, 'Creating errors'));
    }
}
