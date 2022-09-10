<?php

namespace App\Http\Middleware;
use Closure;
use Session;
use Config;
use App;
class SetNovaLocale
{

     private $locales = ['ka', 'en'];
    /**
     * Handle the incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        return $next($request);
    }

}