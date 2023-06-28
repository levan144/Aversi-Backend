<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Hash;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\Rule;
use App\Http\Traits\SmsTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterController extends Controller
{
   use SmsTrait;
//   public function store(RegisterRequest $request) {
//         $user = $request->all();
//         $user['password'] = Hash::make($user['password']);
//         $user['phone_verified_at'] = date('Y-m-d H:i:s');
//         if(!$this->sms_verify($user)){
//             throw new HttpResponseException(response()->json([
//                 'success'   => false,
//                 'message'   => 'SMS error',
//             ]));
//         }
//         $user = Patient::create($user);
//         throw new HttpResponseException(response()->json([
//                 'success'   => true,
//                 'message'   => 'Patient Registered Successfully',
//             ]));
//     }
    
    public function store(RegisterRequest $request) {
    $user = $request->all();
    $user['password'] = Hash::make($user['password']);
    $user['phone_verified_at'] = null; // Null until verification is confirmed
    $user = Patient::create($user);

    // Create token
    $token = $user->createToken('MyApp',['patient'])->accessToken;

    return response()->json([
        'success'   => true,
        'token'     => $token,
        'message'   => 'The patient is registered successfully. Please proceed to SMS verification.',
    ]);
}



    
    
}