<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentBranch;
use App\Models\AppointmentService;
use App\Models\AppointmentServiceCategory;
use App\Models\Doctor;
use App\Models\Specialty;

class AppointmentController extends Controller
{
    public function branches(Request $request) {
    $locale = $request->get('locale', app()->getLocale()); // Default to app locale if none provided
    $search = $request->get('search');

    return AppointmentBranch::all()
        ->map(function ($branch) use ($locale) {
            $branchArray = $branch->toArray();
            $branchArray['title'] = $branch->getTranslation('title', $locale);
            return $branchArray;
        })
        ->filter(function ($branch) use ($search) {
            return str_contains($branch['title'], $search);
        })->values();
}


    
    public function services(Request $request) {
    $locale = $request->get('locale', app()->getLocale()); // Default to app locale if none provided
    $search = $request->get('search');
    $categoryId = $request->get('category_id');

    return AppointmentService::all()
        ->map(function ($service) use ($locale) {
            $serviceArray = $service->toArray();
            $serviceArray['name'] = $service->getTranslation('name', $locale);
            return $serviceArray;
        })
        ->filter(function ($service) use ($search, $categoryId) {
            $matchesSearch = $search ? str_contains($service['name'], $search) : true;
            $matchesCategory = $categoryId ? $service['category_id'] == $categoryId : true;
            return $matchesSearch && $matchesCategory;
        })
        ->values();
}


    
    public function categories(Request $request) {
        $locale = $request->get('locale', app()->getLocale()); // Default to app locale if none provided
        $search = $request->get('search');
    
        return AppointmentServiceCategory::all()
            ->map(function ($category) use ($locale) {
                $categoryArray = $category->toArray();
                $categoryArray['name'] = $category->getTranslation('name', $locale);
                return $categoryArray;
            })
            ->filter(function ($category) use ($search) {
                return str_contains($category['name'], $search);
            });
    }

    
    public function doctors(Request $request) {
    $locale = $request->get('locale', app()->getLocale()); // Default to app locale if none provided
    $search = $request->get('search');
    $branchServiceId = $request->input('branch_service_id');
    $serviceId = $request->input('service_id');

    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/People/list', [
        'headers' => ['Content-Type' => 'application/json'], 
        'json' => ['organizationId' => $branchServiceId, 'serviceId' => $serviceId], 
        'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']
    ]);

    $data = json_decode($res->getBody()->getContents(), true);
    $personalIds = array_column($data, 'personalId');
    foreach($data as $doc) {
        $doctor = Doctor::where('sid', $doc['personalId'])->first();
        if($doctor){
        $doctor->source_id = $doc['sourceId'];
        $doctor->service_id = $doc['id'];
        $doctor->save();
        }
    }
    $doctors = Doctor::whereIn('sid', $personalIds)
                    ->select('id', 'name', 'service_id', 'photo', 'specialty_ids', 'source_id')
                    ->get()
                    ->map(function ($doctor) use ($locale) {
                        $doctorArray = $doctor->toArray();
                        $doctorArray['rating'] = $doctor->rating();
                        $doctorArray['rating_quantity'] = $doctor->rating_quantity();
                        $doctorArray['name'] = $doctor->getTranslation('name', $locale);
                        $doctorArray['specialty'] = $this->getBySpecialtyId($doctor->specialty_ids, $locale); // replaced specialty_ids with specialty
                        return $doctorArray;
                    })
                    ->filter(function ($doctor) use ($search) {
                        return $search ? str_contains($doctor['name'], $search) : true;
                    });

    return $doctors;
}

private function getBySpecialtyId($specialty_ids, $locale = 'ka'){
    $specialties = [];
    // Convert string of specialty_ids to array
    $specialty_ids_array = json_decode($specialty_ids);

    //Get Services by ids
    foreach($specialty_ids_array as $specialty_id){
      $specialty = Specialty::find(intval($specialty_id));
      if($specialty) {
          $specialty_data = [];
          $specialty_data['id'] = $specialty->id;
          $specialty_data['title'] = $specialty->getTranslation('title', $locale);
          $specialties[] = $specialty_data;
      }
    }

    return $specialties;
}


    
   public function schedule(Request $request) {
          try{
            // Get data from request
            $pageNumber = $request->input('pageNumber') ?? 0;
            $pageSize = $request->input('pageSize') ?? 0;
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $clientId = $request->input('clientId') ?? '3fa85f64-5717-4562-b3fc-2c963f66afa6';
            $organizationSourceId = $request->input('organizationSourceId');
            $arrayData = [['serviceSourceId' => $request->input('serviceSourceId'), 'personSourceId' => $request->input('personSourceId'), 'workSpaceId' => null]];
            
            // $servicePersonFilters = $request->input('servicePersonFilters');
        
            // Create request payload
            $payload = [
                'pageNumber' => 0,
                'pageSize' => 0,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'clientId' => $clientId,
                'organizationSourceId' => $organizationSourceId,
                'servicePersonFilters' => $arrayData
            ];
        
            // Create a new Guzzle HTTP client
            $client = new \GuzzleHttp\Client();
        
            // Define authentication credentials
            $username = '4511aac9-57ef-4d83-acea-54b8a1a44ae0';
            $password = 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4';
        
            // Base64 encode the credentials
            $credentials = base64_encode($username . ':' . $password);
        
            // Make the API request
            $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Calendars/getSchedule', [
                'headers' => [
                    'Authorization' => 'Basic ' . $credentials,
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload
            ]);
        
            // Decode the API response
            $data = json_decode($res->getBody()->getContents(), true);
        
            return $data;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
        
            return $responseBodyAsString;
        }
    }
    
    public function setAppointment(Request $request) {
        $user = auth()->user();
        // Create a new Guzzle HTTP client
        $client = new \GuzzleHttp\Client();
        // Define authentication credentials
            $username = '4511aac9-57ef-4d83-acea-54b8a1a44ae0';
            $password = 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4';
        
            // Base64 encode the credentials
            $credentials = base64_encode($username . ':' . $password);
            // Create request payload
            $payload = [
                'client' => [
                    'pid' => $request->input('pid'),
                    'firstName' => $request->input('firstName'),
                    'lastname' => $request->input('lastname'),
                    'phone' => $request->input('phone'),
                    'dateOfBirth' => $request->input('dateOfBirth'),
                ],
                'add' => [
                    'orderNumber' => time(),
                    'branchId' => null,
                    'branchSourceId' => $request->input('branchSourceId'),
                    'personPId' => $request->input('personPId'),
                    // 'workspaceId' => '',
                    'startAt' => $request->input('startAt'),
                    'service' => $request->input('service'),
                    'comment' => 'Test request',
                ]
            ];
            
            // Make the API request
            $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Appointments/Set', [
                'headers' => [
                    'Authorization' => 'Basic ' . $credentials,
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload
            ]);
        
            // Decode the API response
            $data = json_decode($res->getBody()->getContents(), true);
            
    }

}
