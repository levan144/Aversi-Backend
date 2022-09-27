<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\LoginController;

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
Route::get('pages/medicalTourism/{locale}', 'PageController@medicalTourism');
Route::get('pages/afterGraduate/{locale}', 'PageController@afterGraduate');
Route::get('pages/covid/{locale}', 'PageController@covid');
Route::get('pages/services/{locale}', 'PageController@services');
Route::get('pages/laboratory/{locale}', 'PageController@laboratory');
Route::get('pages/home/{locale}', 'PageController@home');
Route::get('pages/contact', 'PageController@contact');
Route::get('pages/rules/{locale}', 'PageController@rules');
//search
Route::get('search/{locale}', 'SearchController@all');



// put all api protected routes here
Route::post('patient/login',[LoginController::class, 'patientLogin'])->name('patientLogin');
Route::middleware('auth:patient-api')->group(function(){
   // authenticated staff routes here 
   Route::post('review/store', 'ReviewController@store');
});

Route::post('doctor/login',[LoginController::class, 'doctorLogin'])->name('doctorLogin');
Route::group( ['prefix' => 'doctor','middleware' => ['auth:doctor-api','scopes:doctor'] ],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'doctorDashboard']);
});   

//CHAT
Route::get('chat', 'ChatController@index');