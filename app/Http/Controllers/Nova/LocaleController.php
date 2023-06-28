<?php
namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use URL;
use App;
class LocaleController extends Controller
{
    /**
     * @param string $locale
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected $languages = ['en','ka'];

   public function handle($locale){
        if (!in_array($locale, ['en', 'ka'])){
            $locale = 'ka';
        }
        Session::put('locale', $locale);
        return redirect(url(URL::previous()));
    }
    
}