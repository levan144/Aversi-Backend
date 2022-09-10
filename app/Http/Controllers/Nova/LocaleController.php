<?php
namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use URL;
class LocaleController extends Controller
{
    /**
     * @param string $locale
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected $languages = ['en','ka'];

   public function handle($locale='ka'){
    if (!in_array($locale, ['en', 'ka'])){
        $locale = 'ka';
    }
    
    \App::setLocale($locale);
    return redirect(url(URL::previous()));
    }
}