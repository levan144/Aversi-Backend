<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
                'doctor_id' => 'required|integer',
                'patient_id' => 'required|integer',
                'rating' => 'required|integer|between:1,5'
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()

    {
        return [
            'doctor_id.required' => 'Doctor ID is required',
            'doctor_id.integer' => 'Doctor ID must be Integer value',
            'patient_id.required' => 'Patient ID is required',
            'patient_id.integer' => 'Patient ID must be Integer value',
            'rating.integer' => 'Rating score must be Integer value',
            'rating.between' => 'Rating score must be between 1-5',

        ];

    }
}
