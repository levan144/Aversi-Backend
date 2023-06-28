<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function setLanguage($language)
    {
        App::setLocale($language);

        session()->put('locale', $language);

        return redirect()->back();
    }
}
