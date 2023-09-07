<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Mail;
use App\Models\Settings;

class EmailController extends Controller
{
    /**
     * Send Vacancy Email
     *
     * @return response()
     */
    public function vacancy(Request $request)
    {
        $data = $request->all();
        $details = [
            'subject' => $data['subject'],
            'name' => $data['name'],
            'email' => $data['email'],
            'attachment' => $data['attachment'] ?? null
        ];
        \Mail::to($details['email'])->send(new \App\Mail\VacancyMail($details));
        return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }
    
     /**
     * Send Internal Audit Email
     *
     * @return response()
     */
    public function internal_audit(Request $request)
    {
        $data = $request->all();
        $file = $data['file'] ?? null;
        $details = [
            'subject' => $data['subject'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
            'presenter' => $data['presenter'],
        ];
        \Mail::to($details['email'])->send(new \App\Mail\InternalAudit($details));
        return response($details->toJson(JSON_PRETTY_PRINT), 200);
        }
    
    /**
     * Send Checkup Email
     *
     * @return response()
     */
    public function checkup(Request $request)
    {
        $email = json_decode(Settings::where('slug', 'checkup')->first(), true)['settings']['email'];
        $data = $request->all();
        $details = [
            'title' => $data['title'],
            'phone' => $data['phone'],
        ];
        
        \Mail::to($email)->send(new \App\Mail\Checkup($details));
        return response($details, 200);
    }
    
    /**
     * Send Checkup Email
     *
     * @return response()
     */
    public function labcall(Request $request)
    {
        $page = json_decode(Settings::where('slug', 'labcall')->first(), true);
        
        $data = $request->all();
        $details = [
            'title' => __('ლაბორატორიის გამოძახება'), // create function to save this string
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ];
        
        \Mail::to($details['email'])->send(new \App\Mail\LaboratoryCall($details));
        return response($details, 200);
    }
	

	public function appointment_rate(Request $request) {
		$data = $request->all();
		$details = [
			'title' => __('ექიმთან ჩაწერის შეფასება'),
			'message' => $data['message'],		
		];
		
	
	}
}
