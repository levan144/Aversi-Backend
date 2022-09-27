<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
class DoctorController extends Controller
{
    public function all(Request $request,$locale) {
      $relations = ['languages','specialties','attached_branches'];

      $per_page = $request->input('per_page') ?? 15;
      $name = $request->input('name') ?? null;
      $specialty = $request->input('specialty') ?? null;
      $branch = $request->input('branch') ?? null;

      $order_by = in_array( strtolower($request->input('order_by')),array('publish_date','rating')) ? $request->input('order_by') : 'publish_date';
      $order = in_array( strtolower($request->input('order')), array('desc','asc')) ? $request->input('order') : 'desc';

      $min_rating = intval($request->input('min_rating')) ?? null;
      $max_rating = intval($request->input('max_rating')) ?? null;

      $items = Doctor::with('specialties');
     
      
      if($specialty){
        $items->whereJsonContains('specialty_ids', $specialty);
      }
      if($branch){
        $items->whereJsonContains('branch_ids', $branch);
      }
      if($order_by){
        $items->orderBy($order_by === 'publish_date' ? 'created_at' : $order_by, $order);
      }
      $items = $items->paginate($per_page);
      $mapped = $items->map(function ($item) use ($locale,$relations,$name) {
            $item['rating'] = $item->rating();
            $item = collect($item)->map(function ($key, $value) use ($locale,$relations,$name, $item) {
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
                  } 
                  return false;
                } 
              return $key;
          });
          if($item['name']) {
            return $item;
          }
          return null;
      });

      if($min_rating > 0){
        $mapped = $mapped->where('rating', '>=', $min_rating);
      }

      if($max_rating <= 5){
        $mapped = $mapped->where('rating', '<=', $max_rating);
      }
     
      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $per_page, 'data' => $mapped));
      return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }
    

    public function single($id,$locale) {
      $relations = ['languages'];
      $doctor = Doctor::FindorFail($id);
      $doctor->rating = $doctor->rating();
      $mapped = collect($doctor)->map(function ($key, $value) use ($locale,$relations) {
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
