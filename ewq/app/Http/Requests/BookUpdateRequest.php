<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'nullable|string',
            'anons' => 'nullable|string',
            'author' => 'nullable|string',
            'image' => 'nullable|file|mimes:png,jpg',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id'

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
