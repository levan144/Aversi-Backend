<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as MessageValidator;
use Illuminate\Validation\Rule;


class RegisterRequest extends FormRequest

{

    public function rules()

    {

        return [
            'name' => 'required',
            'last_name' => 'required',
            'gender' => [ 'required', Rule::in(['male', 'female']) ],
            'birthdate' => 'required|date_format:Y-m-d',
            'citizenship' => [ 'required', Rule::in(['georgia', 'foreign']) ],
            'sid' => 'required|unique:patients',
            'phone' => 'required',
            'email' => 'required|email|unique:patients',
            'password' => 'required',
            // 'sms_code' => 'required'
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