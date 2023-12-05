<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function all(Request $request,$locale) {
      $per_page = $request->input('per_page') ?? 200;
      $relations = [];
      $items = Specialty::query();
      $items = $items->paginate($per_page);
      $mapped = $items->map(function ($item) use ($locale,$relations) {
            $item = collect($item)->map(function ($key, $value) use ($locale,$relations) {

              if(is_array($key) and !in_array($value, $relations)){
                 if(isset($key[$locale])) {
                  $key = $key[$locale];
                } else {
                  $key = null;
                }

              }
              
              return $key;
          });
          
             return $item;
      });

      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $per_page, 'data' => $mapped));
      return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function single($id,$locale) {
      $relations = [];
      $service = Specialty::with($relations)->FindorFail($id);
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
