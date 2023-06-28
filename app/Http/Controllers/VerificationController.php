<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\SmsSendRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerificationController extends Controller
{
    /**
     * Send SMS Code
     *
     */
    public function sms_send(SmsSendRequest $request)
    {
        $user = Auth::guard('patient-api')->user(); // Get the currently authenticated user
        if($user->phone_verified_at){
        return response()->json([
                'success'   => false,
                'message'   => 'Patient already verified',
            ]);
    }
        // Prepare API base64 auth
        $token = base64_encode('d01a667f-a60e-4772-9ac4-46d7e378442e:ebd6b155-782b-4131-a237-a530da11d5ba'); //replace user and password
    
        // Sending verification code
        $response = Http::withHeaders([
            'Authorization' => 'Basic '.$token,
            'Content-Type' => 'application/json'
        ])->post('https://clinic-webmed.aversiclinic.ge/Patient/SendSmsVerification', [
            'pid' => $user['sid'],
            'mobile' => $user['phone'],
            'dateOfBirth' => $user['birthdate'],
            'firstname' => $user['name'],
            'lastname' => $user['last_name']
        ]);
        if ($response->failed()) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'SMS error',
            ], $response->status()));
        }
        return response()->json([
            'success'   => true,
            'sms_id' => $response['id'],
            'message'   => 'The SMS verification code has been sent to the phone',
        ]);
    }
    
    public function sms_verify(Request $request) {
    $user = Auth::guard('patient-api')->user(); // Get the currently authenticated user
    if($user->phone_verified_at){
        return response()->json([
                'success'   => false,
                'message'   => 'Patient already verified',
            ]);
    }
    // Base64 auth
    $token = base64_encode('d01a667f-a60e-4772-9ac4-46d7e378442e:ebd6b155-782b-4131-a237-a530da11d5ba'); //replace user and password

    // Send SMS code verification
    $response = Http::withHeaders([
        'Authorization' => 'Basic '.$token,
        'Content-Type' => 'application/json'
    ])->post('https://clinic-webmed.aversiclinic.ge/Patient/VerifySms', [
        'id' => $request->sms_id,
        'pid' => $user->sid,
        'mobile' => $user->phone,
        'dateOfBirth' => $user->birthdate,
        'firstname' => $user->name,
        'lastname' => $user->last_name,
        'smsCode' => $request->sms_code
    ]);
    
    // Check if the request was successful
    if($response->successful()){
        $response = $response->json();
        // Check errorCode in the response
        if($response['errorCode'] == 0){
            // ErrorCode is 0, user is verified
            $user = Patient::find($request->id);
            $user->phone_verified_at = now();
            $user->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Patient verified successfully',
            ]);
        }else{
            // ErrorCode is 1 or more, do not verify user
            return response()->json([
                'success'   => false,
                'message'   => 'Verification failed',
            ]);
        }
    }else{
        // The request failed
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Verification error',
        ], $response->status()));
    }
}
    
}