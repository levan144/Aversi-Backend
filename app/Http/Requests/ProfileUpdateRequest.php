<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as MessageValidator;
use Illuminate\Validation\Rule;


class ProfileUpdateRequest extends FormRequest

{

    public function rules()
    {
    $patient = Auth::guard('patient-api')->user();
        return [
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required',
            'last_name' => 'required',
            'gender' => [ 'required', Rule::in(['male', 'female']) ],
            'birthdate' => 'required|date_format:Y-m-d',
            'citizenship' => [ 'required', Rule::in(['georgia', 'foreign']) ],
            'sid' => 'required|unique:patients,sid,' . $patient->id,
            'phone' => 'required',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'show_in_comments' => 'boolean'
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