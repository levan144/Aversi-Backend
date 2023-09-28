<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function all(Request $request, $locale) {
      $per_page = $request->input('per_page') ?? 15;
      $is_region = $request->input('is_region');
      //$start_date = $request->input('start_date') ?? null;
      //$end_date = $request->input('end_date') ?? null;
      $type = $request->input('type') ?? null;
      $items = Branch::with('services','region');
      //if($start_date and $end_date) {
        //$items = $items->whereBetween('created_at', [
        //  $start_date, $end_date
        //]);
      //}
      if($type){
        $items->where('type', $type);
      }
      if($is_region === '1'){
        $items->where('region_id', '!=' ,1);
      } elseif($is_region == 0) {
	$items->where('region_id', 1);
	}
      $items = $items->paginate($per_page);
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

      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $per_page, 'data' => $mapped));
      return response($details, 200);
    }

    public function single($id,$locale) {
      $item = Branch::with('services','region')->findorFail($id);
      $item->gallery = $item->getMedia('photo');
      $mapped = collect($item)->map(function ($key, $value) use ($locale) {
        
        if(is_array($key)  and !in_array($value, ['services', 'region','working_time'])){
          if(isset($key[$locale])) {
            $key = $key[$locale];
            return $key;
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
      return response($mapped, 200);
    }
}
