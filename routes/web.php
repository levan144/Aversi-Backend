<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Post;
use App\Models\Doctor;

use App\Models\Promotion;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/nova');
});
Route::get('/login', function () {
   return response()->json([
            'success'   => false,
            'message'   => 'Patient is not authenticated',
        ]);
})->name('login');

Route::get('cron/research_quantity_sum', 'CustomDataController@store_research_quantity_sum');


Route::post('/payments/redirect', function(Request $request){
    return $request->all();
});
Route::get('/set-language/{language}', 'LanguageController@setLanguage');

Route::get('/testroute', function(){
    $client = new GuzzleHttp\Client();
    
    // $res = $client->request('GET', 'https://rustavi-webmed.aversiclinic.ge/Statistic/TotalVisits', ['auth' => ['4a26d78c-ff15-41fa-87ce-61881c5ce91e', '90446098-e567-4490-8bab-fae4273420ab']]);
    // $res = $client->request('GET', 'https://clinic-webmed.aversiclinic.ge/Patient/SendSmsVerification', ['auth' => ['d01a667f-a60e-4772-9ac4-46d7e378442e', 'ebd6b155-782b-4131-a237-a530da11d5ba']]);
        // $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Services/list', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
        // 'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    //  $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Calendars/getSchedule', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
    //     'organizationSourceId' => '5', 'startDate' => '2023-06-08T06:12:44.359Z', 'endDate' => '2023-06-09T06:12:44.359Z'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    
    
    $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/People/list', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
        'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    // foreach(json_decode($res->getBody()) as $doc) {
    //     $doctor = Doctor::where('sid', $doc->personalId)->first();
    //     if($doctor){
    //         $doctor->service_id = $doc->id;
    //         $doctor->save();
    //     }
        
    // }
    // $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Organizations/list', [
    //     'headers' => ['Content-Type' => 'application/json'], 
    //     'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4'],
    //     'json' => [
    //         'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'],
    //     ]);
    dd(json_decode($res->getBody()));
    
});

 function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}


// Route::get('/news', function(){
//   $articles = Article::where('cat_id', 3)->get();
// $cyr  = array('ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ', 
//             'ქ','ღ','ყ','შ','ჩ','ც','ძ','წ', 'ჭ', 'ღ' ,'ხ','ჯ', 'ჰ', ' ');
            
// $lat = array( 'a','b','g','d','e','v','z','t','i','k','l','m','n','o','p','dj','r','s','t','u',
//             'f' ,'q' ,'gh' ,'y','sh' ,'ch' ,'c', 'dz', 'w', 'ch' ,'gh' ,'kh', 'j','h','-');

// // $textcyr = str_replace($cyr, $lat, $textcyr);
// // $textlat = str_replace($lat, $cyr, $textlat);
// foreach($articles as $article){
// $blog = new Promotion;
// $title = ['en' => $article->title_en, 'ka' => $article->title_ka, 'ru' => $article->title_ru];
// $slug = ['en' => str_replace($cyr, $lat, $article->title_en), 'ka' => str_replace($cyr, $lat, $article->title_ka), 'ru' => str_replace($cyr, $lat, $article->title_ru)];
// $content = ['en' => $article->full_en, 'ka' => $article->full_ka, 'ru' => $article->full_ru];
// $blog->title = $title;
// $blog->slug = $slug;
// $blog->content = $content;
// $blog->user_id = 1;
// $blog->status = 1;
// $blog->created_at = $article->publish_up;
// $blog->cover_image = $article->cover;
// // $blog->category_id = $article->cat_id;
//  $blog->save();
// }
//     'done';

// });