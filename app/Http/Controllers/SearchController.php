<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\LaboratoryService;
use App\Models\Branch;
use App\Models\Job;
use App\Models\Promotion;
use Illuminate\Support\Arr;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{

  public function all(Request $request, $locale) {
    $search_term = $request->input('search_term');
    $perPage = intval($request->input('per_page'));
    if(!$perPage){
      $perPage = 15;
    }
    $results = Search::add(Blog::class, 'title->' . $locale)
    ->add(Post::class, 'title->' . $locale)
    ->add(Doctor::class, 'name->' . $locale)
    ->add(Service::class, 'title->' .$locale)
    ->add(LaboratoryService::class, 'title->' . $locale)
    ->add(Branch::class, 'title->' . $locale)
    ->add(Job::class, 'title->' . $locale)
    ->add(Promotion::class, 'title->' . $locale)
    ->beginWithWildcard()
    ->orderByRelevance()
    ->includeModelType()
    ->paginate($perPage, $pageName = 'page', $page = $request->input('page') ?? 1)
    ->search($search_term);
    $mapped = $results->map(function ($item) use ($locale) {
            $item = collect($item)->map(function ($key, $value) use ($locale) {
              if(is_array($key) and $value !== 'author'){

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
    $details = collect(array('per_page' => $perPage, 'page_number' => $results->currentPage(), 'max_pages' => $results->lastPage(), 'search_term' => $search_term, 'results' => $mapped->count(),  'data' => $mapped));
    return response($details->toJson(JSON_PRETTY_PRINT), 200);
  }
   
    
}
