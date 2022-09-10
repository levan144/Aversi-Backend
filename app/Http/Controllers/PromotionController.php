<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
     public function all(Request $request, $locale) {
      $per_page = $request->input('per_page') ?? 15;
      $items = Promotion::paginate($per_page);
      $mapped = $items->map(function ($item) use ($locale) {
            $item = collect($item)->map(function ($key, $value) use ($locale) {
              if(is_array($key)){
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
      $item = Promotion::FindorFail($id);
      $mapped = collect($item)->map(function ($key, $value) use ($locale) {
        if(is_array($key)){
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
