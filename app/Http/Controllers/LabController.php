<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaboratoryService;
use App\Models\LaboratoryCategory;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Illuminate\Database\Eloquent\Builder;
class LabController extends Controller
{
    public function all_services(Request $request,$locale) {
        $relations = ['getCategory'];
        $category_id = intval($request->input('category_id')) ?? null;
        if(!$category_id){
          $searchType = LaboratoryService::where('status', '=', 1);
        } else {
          $searchType = LaboratoryService::where('category_id', $category_id)->where('status', '=', 1);
        }
        $perPage = intval($request->input('per_page'));
          if(!$perPage){
            $perPage = 15;
          }
        $search_term = $request->input('search_term') ?? null;
        $items = Search::add($searchType, ['title->' . $locale])
        ->beginWithWildcard()
        ->orderByRelevance()
        ->paginate($perPage, $pageName = 'page', $page = $request->input('page') ?? 1)
        ->search($search_term);
     
        
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
        $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $perPage, 'data' => $mapped));
        return response($details->toJson(JSON_PRETTY_PRINT), 200);
      }

      public function single_service($id, $locale)
{
    $service = LaboratoryService::findOrFail($id);

    $attributes = [
        'id' => $service->id,
        'title' => $service->getTranslation('title', $locale),
        'content' => $service->getTranslation('content', $locale) ?? null,
        'status' => $service->status,
        'category_id' => $service->category_id,
        'created_at' => $service->created_at,
        'updated_at' => $service->updated_at,
    ];

    return response()->json($attributes, 200);
}
  
      public function all_categories(Request $request,$locale) {
       $relations = ['services'];
        $searchType = LaboratoryCategory::class;
        $perPage = intval($request->input('per_page')) ?? 15;
        $search_term = $request->input('search_term') ?? null;
        
        $items = Search::add($searchType, ['title->' . $locale, 'services.title->' . $locale])
            ->beginWithWildcard()
            // ->orderByRelevance()
            ->paginate($perPage, $pageName = 'page', $page = $request->input('page') ?? 1)
            ->search($search_term);
        
        $mapped = $items->map(function ($item) use ($locale) {
            return collect($item)->map(function ($key, $value) use ($locale) {
                return is_array($key) ? ($key[$locale] ?? null) : $key;
            });
        });
        
        $details = [
            'page_number' => $items->currentPage(),
            'max_pages' => $items->lastPage(),
            'per_page' => $perPage,
            'data' => $mapped,
        ];
        
        return response()->json($details, 200);
      }

      public function single_category($id,$locale) {
       $service = LaboratoryCategory::findOrFail($id);
        $mapped = collect($service)->map(function ($value, $key) use ($locale) {
            if (is_array($value)) {
                $value = $value[$locale] ?? null;
            }
            return $value;
        });
        return response()->json($mapped, 200);
      }
}
