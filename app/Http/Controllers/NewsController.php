<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class NewsController extends Controller
{
    public function all(Request $request, $locale) {
      $per_page = $request->input('per_page') ?? 15;
      $start_date = $request->input('start_date') ?? null;
      $end_date = $request->input('end_date') ?? null;
      $items = Post::with('author')->where('status', '=', 1);
      if($start_date and $end_date) {
        $items = $items->whereBetween('created_at', [
          $start_date, $end_date
        ]);
      }
      $items = $items->paginate($per_page);
      $mapped = $items->map(function ($item) use ($locale) {
            $item->gallery = $item->getMedia('gallery');
            $item = collect($item)->map(function ($key, $value) use ($locale) {
                 
              if(is_array($key) and $value !== 'author' and $value !== 'gallery'){

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
      
      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $per_page, 'start_date' => $start_date, 'end_date' => $end_date, 'data' => $mapped));
      return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function single($id, $locale) {
      $post = Post::with('author')->findorFail($id);
    $post->gallery = $post->getMedia('gallery');
      $mapped = collect($post)->map(function ($key, $value) use ($locale) {
         
        if(is_array($key)  and $value !== 'author' and $value !== 'gallery'){
          if(isset($key[$locale])) {
            $key = $key[$locale];
            return $key;
          } else {
            $key = null;
          }
        }
         return $key;
      });

      return response($mapped->toJson(JSON_PRETTY_PRINT), 200);
    }

}
