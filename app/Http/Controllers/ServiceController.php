<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Region;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Illuminate\Database\Eloquent\Builder;
class ServiceController extends Controller
{
    public function all(Request $request,$locale) {
      $relations = ['branches'];
      $branch_id = intval($request->input('branch_id')) ?? null;
      if(!$branch_id){
        $searchType = Service::with('branches')->where('status', '=', 1);
      } else {
	$branch = Branch::findOrFail($branch_id);
        $searchType = Service::whereIn('id', $branch->service_ids);
      }
      $perPage = intval($request->input('per_page'));
        if(!$perPage){
          $perPage = 15;
        }
      $search_term = $request->input('search_term') ?? null;
      $items = Search::add($searchType, ['title->' . $locale])
      ->beginWithWildcard()
      ->orderByRelevance()
      ->includeModelType()
      ->paginate(100, $pageName = 'page', $page = $request->input('page') ?? 1)
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

              if(in_array($value, ['branches'])){
                $key = collect($key)->map(function ($branch, $val) use ($locale) {
                   
                      $branch['title'] = $branch['title'][$locale] ?? null;
                      $branch['description'] = $branch['description'][$locale] ?? null;
                      $branch['address'] = $branch['address'][$locale] ?? null;
                      $branch['region'] = json_decode(Region::find($branch['region_id']))->title->$locale;

              
                      return $branch;
                    
                    
                });
              }

              return $key;
          });
            return $item;
            
      });
      $details = collect(array('page_number' => $items->currentPage(), 'max_pages' => $items->lastPage(), 'per_page' => $perPage, 'data' => $mapped));
      return response($details->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function single($id,$locale) {
      $relations = [];
      $service = Service::with($relations)->FindorFail($id);
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
	$mapped->toArray();
	$mapped['branches'] = Branch::where('service_ids','like' ,'%'.$id.'%')->with('region')->get()->toArray();
	$mapped['branches'] = array_map(function ($branch) use ($locale) {
        // Load translatable fields in the specified locale
   	$branch['title'] = $branch['title'][$locale] ?? null;
	$branch['description'] = $branch['description'][$locale] ?? null;
	$branch['address'] = $branch['address'][$locale] ?? null;
	$branch['note'] = $branch['note'][$locale] ?? null;
	$branch['emergency'] = $branch['emergency'][$locale] ?? null;
	$branch['region'] = $branch['region']['title'][$locale] ?? null;
   //     $branch->address = $branch->getTranslation('address', $locale);
	
        return $branch;
    }, $mapped['branches']);
      return response($mapped, 200);
    }
}
