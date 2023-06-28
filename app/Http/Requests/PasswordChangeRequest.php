<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as MessageValidator;
use Illuminate\Validation\Rule;


class PasswordChangeRequest extends FormRequest

{

    public function rules()

    {

        return [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed'
        ];

    }



    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }



    public function messages()

    {
        
        return [
            
        ];


    }

}