<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Hash;
use Validator;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }
    
    
   public function store(array $data) {
        $this->validate($data, [
            'name' => 'required',
            'last_name' => 'required',
            'gender' => [ 'required', Rule::in(['male', 'female']) ],
            'birthdate' => 'required|date_format:Y-m-d',
            'citizenship' => [ 'required', Rule::in(['georgia', 'foreaign']) ],
            'sid' => 'required|integer|unique:patients',
            'phone' => 'required',
            'email' => 'required|email|unique:patients',
            'password' => 'required'
        ]);
        dd($data);
        $user = Patient::create($data);
        return response(true, 200);
    }
}