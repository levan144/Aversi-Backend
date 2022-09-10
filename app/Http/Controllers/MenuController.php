<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Outl1ne\MenuBuilder\Models\Menu;
use Outl1ne\MenuBuilder\Models\MenuItem;
class MenuController extends Controller
{
    public function allPositions() {
      $menus = Menu::all();
      return response($menus, 200);
    }

    public function singlePosition($id) {
      $menus = Menu::findOrFail($id);
      return response($menus, 200);
    }

    public function allItems($locale) {
      $menus = MenuItem::where('locale', $locale)->get();
      return response($menus, 200);
    }

    public function allItemsByPosition($name, $locale) {
      $menu = Menu::where('slug', $name)->first();
      $menus = MenuItem::where('locale', $locale)->where('menu_id', $menu->id)->orderBy('order', 'asc')->get();
      return response($menus, 200);
    }

    public function singleItem($id) {
      $menus = MenuItem::findOrFail($id);
      return response($menus, 200);
    }
}
