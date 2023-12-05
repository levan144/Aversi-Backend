<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Password;
class PasswordResetController extends Controller
{
    public function check(Request $request) {
	$email = $request->email;
	if(!Patient::where('email', $email)->exists()){
		return response()->json(['message' => 'Email is not registered', 'status' => false]);
	}
    }

    public function send(Request $request){
	$request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => trans($status)], 200)
            : response()->json(['error' => trans($status)], 400);
	}

    public function verify(){

	}

    public function change_password(){

	}
}
