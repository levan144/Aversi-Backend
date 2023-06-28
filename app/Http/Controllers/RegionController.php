<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
class RegionController extends Controller
{
    public function all(Request $request, $locale) {
      

      $items = Region::select('id', 'title')->get()->map(function ($item) use ($locale) {
        $item->title = $item->getTranslation('title', $locale);
        return ['id' => $item->id, 'title' => $item->title];
      });
      return response($items, 200);
    }

    public function single($id, $locale) {
      $item = Region::findOrFail($id);
      $data = ['id' => $id,'title' => $item->getTranslation('title', $locale)];
      return response($data, 200);
    }
}
