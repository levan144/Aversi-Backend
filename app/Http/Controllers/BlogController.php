<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Arr;
class BlogController extends Controller
{

  public function all(Request $request, $locale) {
    $per_page = $request->input('per_page', 12);
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $page = $request->input('page', 1);
    $query = Blog::where('status', 1)
        //->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
        //    $query->whereBetween('created_at', [$start_date, $end_date]);
        //})
        ->orderByDesc('created_at')->orderBy('id', 'desc');

    $items = $query->paginate($per_page, '*' , 'page', $page);

    $mapped = $items->map(function ($item) use ($locale) {
        return collect($item->toArray())->map(function ($key) use ($locale) {
            return is_array($key) ? ($key[$locale] ?? null) : $key;
        });
    });

    $details = [
        'page_number' => $items->currentPage(),
        'max_pages' => $items->lastPage(),
        'per_page' => $per_page,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'data' => $mapped,
    ];

    return response()->json($details, 200);
}

    public function single($id, $locale) {
      $blog = Blog::with('author')->findorFail($id);
  
      $mapped = collect($blog)->map(function ($key, $value) use ($locale) {
        if(is_array($key)  and $value !== 'author'){
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
