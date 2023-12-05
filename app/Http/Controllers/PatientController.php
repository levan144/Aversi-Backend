<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Illuminate\Http\Exceptions\HttpResponseException;
class PatientController extends Controller
{
    
    
    public function password_change(PasswordChangeRequest $request) {
        $patient = Auth::guard('patient-api')->user();
        $validator = Validator::make($request->all(), [
        'old_password' => [
            'required', function ($attribute, $value, $fail) use($patient) {
                if (!Hash::check($value, $patient->password)) {
                    $fail('Old Password didn\'t match');
                }
            },
        ],
    ]);
    
    if($validator->fails()) {
        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));
    } 
        $patient->password = Hash::make($request->new_password);
        $patient->save();
    

        return response()->json([
            'success'   => true,
            'message'   => 'Password updated successfully',
        ]);
    }
    
    public function profile_update(ProfileUpdateRequest $request){
        $patient = Auth::guard('patient-api')->user();
	if($request->file('photo')) {
        $image_path = $request->file('photo')->store('patients', 'public');
        $data = $request->all();
        $data['photo'] = $image_path;
	}
        $patient->update($data);
        return response()->json([
            'success'   => true,
            'message'   => 'Profile updated successfully',
        ]);
    }
    
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

}
