<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function all(Request $request) {
      $per_page = $request->input('per_page') ?? 15;
      $items = Partner::paginate($per_page);
      return response($items, 200);
    }

    public function single($id) {
      $item = Partner::findOrFail($id);
      return response($item, 200);
    }
}
