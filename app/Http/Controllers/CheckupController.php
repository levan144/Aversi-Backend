<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckupPlan;
use App\Models\CheckupService;
use App\Imports\LabCatImport;
use App\Imports\DoctorImport;
use App\Imports\SpecialtyImport;
use App\Models\Doctor;
use App\Models\LaboratoryService;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
class CheckupController extends Controller
{
    public function test(Request $request) {
        
        // $service = LaboratoryService::query()->update(['status' => 1]);
        Excel::import(new DoctorImport, $request->file('attachment'));
        
        return redirect('/')->with('success', 'All good!');
        // $plans = CheckupPlan::all();
        // return response($plans, 200);
    }
    
    
}
