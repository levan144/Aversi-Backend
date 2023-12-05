<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('test', 'CheckupController@test');

Route::get('blogs/{locale}', 'BlogController@all');
Route::get('blog/{id}/{locale}', 'BlogController@single');

Route::get('posts/{locale}', 'NewsController@all');
Route::get('post/{id}/{locale}', 'NewsController@single');

Route::get('branches/{locale}', 'BranchController@all');
Route::get('branch/{id}/{locale}', 'BranchController@single');

Route::get('services/{locale}', 'ServiceController@all');
Route::get('service/{id}/{locale}', 'ServiceController@single');

Route::get('promotions/{locale}', 'PromotionController@all');
Route::get('promotion/{id}/{locale}', 'PromotionController@single');

Route::get('vacancies/{locale}', 'JobController@all');
Route::get('vacancy/{id}/{locale}', 'JobController@single');

Route::get('galleries/{locale}', 'GalleryController@all');
Route::get('gallery/{id}/{locale}', 'GalleryController@single');

Route::get('partners', 'PartnerController@all');
Route::get('partner/{id}', 'PartnerController@single');

Route::get('doctors/{locale}', 'DoctorController@all');
Route::get('doctor/{id}/{locale}', 'DoctorController@single');

Route::get('specialties/{locale}', 'SpecialtyController@all');
Route::get('specialty/{id}/{locale}', 'SpecialtyController@single');

Route::get('regions/{locale}', 'RegionController@all');
Route::get('region/{id}/{locale}', 'RegionController@single');

Route::get('analysis/{locale}', 'LabController@all_services');
Route::get('analysis/{id}/{locale}', 'LabController@single_service');

Route::get('analysis_categories/{locale}', 'LabController@all_categories');
Route::get('analysis_category/{id}/{locale}', 'LabController@single_category');

//Navigation
Route::get('menus/positions', 'MenuController@allPositions');
Route::get('menus/positions/{id}', 'MenuController@singlePosition');
Route::get('menus/items/{locale}', 'MenuController@allItems');
Route::get('menus/itemsbyposition/{id}/{locale}', 'MenuController@allItemsByPosition');
Route::get('menus/items/{id}', 'MenuController@singleItem');

//Pages

Route::get('pages/about/{locale}', 'PageController@aboutUs');
Route::get('pages/partners/{locale}', 'PageController@partners');
Route::get('pages/medicalTourism/{locale}', 'PageController@medicalTourism');
Route::get('pages/afterGraduate/{locale}', 'PageController@afterGraduate');
Route::get('pages/covid/{locale}', 'PageController@covid');
Route::get('pages/services/{locale}', 'PageController@services');
Route::get('pages/laboratory/{locale}', 'PageController@laboratory');
Route::get('pages/home/{locale}', 'PageController@home');
Route::get('pages/contact/{locale}', 'PageController@contact');
Route::get('pages/rules/{locale}', 'PageController@rules');
Route::get('pages/vacancies/{locale}', 'PageController@vacancies');
Route::get('pages/report/{locale}', 'PageController@report');

//search
Route::get('search/{locale}', 'SearchController@all');

//SMS
Route::post('sms/send', 'VerificationController@sms_send')->name('sms.send');
Route::post('sms/verify', 'VerificationController@sms_verify')->name('sms.verify');

Route::post('reset/check', 'PasswordResetController@check')->name('email.reset.check');
Route::post('reset/send', 'PasswordResetController@send')->name('email.reset.send');
Route::post('reset/verify', 'PasswordResetController@verify')->name('email.reset.verify');
Route::post('reset/password', 'PasswordResetController@password')->name('email.reset.password');

// put all api protected routes here
Route::post('patient/register',[RegisterController::class, 'store'])->name('patient.register');
Route::post('patient/login',[LoginController::class, 'patientLogin'])->name('patient.login');
Route::middleware('auth:patient-api')->group(function(){
   // authenticated staff routes here 
   Route::post('patient/logout', 'PatientController@logout')->name('patient.logout');
   Route::post('patient/edit/password', 'PatientController@password_change')->name('patient.edit.password');
   Route::post('patient/edit/profile', 'PatientController@profile_update')->name('patient.edit.password');
   Route::post('review/store', 'ReviewController@store');
   
   //APPOINTMENT
   Route::group( ['prefix' => 'appointment'],function(){
        Route::get('branches', 'AppointmentController@branches');
        Route::get('categories', 'AppointmentController@categories');
        Route::get('services', 'AppointmentController@services');
        Route::get('doctors', 'AppointmentController@doctors');
        Route::get('schedule', 'AppointmentController@schedule');
        Route::get('set', 'AppointmentController@setAppointment');
   });
});

Route::post('doctor/login',[LoginController::class, 'doctorLogin'])->name('doctorLogin');
Route::group( ['prefix' => 'doctor','middleware' => ['auth:doctor-api','scopes:doctor'] ],function(){
   // authenticated staff routes here 
    // Route::get('dashboard',[LoginController::class, 'doctorDashboard']);
});   

//CHAT
Route::get('chat', 'ChatController@index');




//Mail
Route::post('email/vacancy', 'EmailController@vacancy');
Route::post('email/internal_audit', 'EmailController@internal_audit');
Route::post('email/labcall', 'EmailController@labcall');
Route::post('email/checkup', 'EmailController@checkup');
Route::post('email/ratevisit', 'EmailController@appointment_rate');

