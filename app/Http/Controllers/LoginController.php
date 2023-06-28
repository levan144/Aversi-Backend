<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    public function patientDashboard()
    {
        $patients = Patient::all();
        $success =  $patients;

        return response()->json($success, 200);
    }

    public function doctorDashboard()
    {
        $doctors = Doctor::all();
        $success =  $doctors;

        return response()->json($success, 200);
    }

    public function patientLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('patient')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'patient']);
            
            $user = Patient::select('patients.*')->find(auth()->guard('patient')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['patient'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function doctorLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('doctor')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'doctor']);
            
            $doctor = Doctor::select('doctors.*')->find(auth()->guard('doctor')->user()->id);
            $success =  $doctor;
            $success['token'] =  $doctor->createToken('MyApp',['doctor'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
}