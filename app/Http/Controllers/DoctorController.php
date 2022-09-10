<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
class DoctorController extends Controller
{
    public function all(Request $request,$locale) {
      $per_page = $request->input('per_page') ?? 15;
      $relations = ['languages','specialties','attached_branches'];
      $name = $request->input('name') ?? null;
      $specialty = $request->input('specialty') ?? null;
      $branch = $request->input('branch') ?? null;
      $items = Doctor::query()->with('specialties');
      if($specialty){
        $items->whereJsonContains('specialty_ids', $specialty);
      }
      if($branch){
        $items->whereJsonContains('branches', $branch);
      }
      $items = $items->paginate($per_page);
      $mapped = $items->map(function ($item) use ($locale,$relations,$name) {
            $item = collect($item)->map(function ($key, $value) use ($locale,$relations,$name) {

              if(is_array($key) and !in_array($value, $relations)){
                if(isset($key[$locale])) {
                  $key = $key[$locale];

                } else {
                  $key = null;
                }

              } 
                if($value === 'name' and $name) {

                        if(preg_match("/{$name}/i", $key)) {
                            return $key;
                        } else {
                            return false;
                        }
                } 
              return $key;
          });
            if($item['name']) {
                return $item;
            } else {
                return null;
            }
            
            
      });

      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $per_page, 'data' => $mapped));
      return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }
    

    public function single($id,$locale) {
      $relations = ['languages'];
      $service = Doctor::FindorFail($id);
      $mapped = collect($service)->map(function ($key, $value) use ($locale,$relations) {
        if(is_array($key)  and !in_array($value, $relations)){
          if(isset($key[$locale])) {
            $key = $key[$locale];
            return $key;
          } else {
            $key = null;
          }
        }
         return $key;
      });

      return response($mapped, 200);
    }
}
