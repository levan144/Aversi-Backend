<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Service;
use DB;
class BranchController extends Controller
{
    public function all(Request $request, $locale) {
      $per_page = $request->input('per_page') ?? 15;
      $is_region = $request->input('is_region') ?? 2;
      $start_date = $request->input('start_date') ?? null;
      $end_date = $request->input('end_date') ?? null;
      $type = $request->input('type') ?? null;
      $items = Branch::with('services','region');
      if($start_date and $end_date) {
        $items = $items->whereBetween('created_at', [
          $start_date, $end_date
        ]);
      }
      if($type){
        $items->where('type', $type);
      }
      if(in_array($is_region, [1,0])){
        $items->whereHas('region', function($query) use( $is_region ) {
	$query->where('is_region', $is_region);
	});
      }
      $items = $items->paginate(100);
      $mapped = $items->map(function ($item) use ($locale) {
            $item->gallery = $item->getMedia('photo');
            $item = collect($item)->map(function ($key, $value) use ($locale) {
              if(is_array($key) and !in_array($value, ['services','region','working_time'])){
                if(isset($key[$locale])) {
                  $key = $key[$locale];
                } else {
                  $key = null;
                }
              } 
              if(in_array($value, ['services'])){
                $key = collect($key)->map(function ($service, $val) use ($locale) {
                  if(is_array($service) and !in_array($val, ['title', 'content'])){

                    $service['title'] = $service['title'][$locale] ?? null;
                    $service['content'] = $service['content'][$locale] ?? null;
                  }
                  return $service;
                });
              }
              if(in_array($value, ['region'])){
                $key = collect($key)->map(function ($region, $val) use ($locale) {
                  if(is_array($region) and in_array($val, ['title'])){
                    $region = $region[$locale] ?? null;
                  }
                  return $region;
                });
        }
              return $key;
          });
            return $item;
      });

      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => 50, 'start_date' => $start_date, 'end_date' => $end_date, 'data' => $mapped, 'meta' => ['title' => 'ფილიალები']));
      return response($details, 200);
    }

    public function single($id, $locale) {
      $item = Branch::with('services', 'region')->findOrFail($id);
      $item->gallery = $item->getMedia('photo');
  
      $mapped = collect($item)->map(function ($key, $value) use ($locale) {
  
          if(is_array($key)  and !in_array($value, ['service_ids', 'region', 'working_time'])) {
              if(isset($key[$locale])) {
                  return $key[$locale];
              } else {
                  return null;
              }
          }
  
          if(in_array($value, ['services'])) {
              	
		//return $this->transformServices($key, $locale);
          }
  
          if(in_array($value, ['region'])) {
              return collect($key)->map(function ($region, $val) use ($locale) {
                  if(is_array($region) and in_array($val, ['title'])) {
                      return $region[$locale] ?? null;
                  }
                  return $region;
              });
          }
  
          return $key;
  
      });

//	$mapped['services'] = Service::whereIn('id', $item->service_ids)->select('id', 'title->'. $locale, 'content', 'icon')->get();
  $mapped['services'] = Service::whereIn('id', $item->service_ids)
    ->select(
        'id',
        DB::raw("title->'$.$locale' as title"), 
        DB::raw("content->'$.$locale' as content"), 
        'icon'
    )->get();
      return response($mapped, 200);
  }
  

    protected function transformServices($services, $locale) {
      return collect($services)->map(function ($service) use ($locale) {
          if(is_array($service)) {
              $service['title'] = $service['title'][$locale] ?? null;
              $service['content'] = $service['content'][$locale] ?? null;
          }
          return $service;
      });
  }
  
}
