<?php

namespace App\Http\Middleware;
use Closure;
use Session;
use Config;
use App;
use Illuminate\Support\Arr;
class SetNovaLocale
{

     private $locales = ['ka', 'en'];
    /**
     * Handle the incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() === 'GET') {
            $segment = $request->segment(count(request()->segments()));

            if (!in_array($segment, config('app.locales'))) {
                $segments = $request->segments();
                $fallback = session('locale') ?: config('app.fallback_locale');

                $segments[] = $fallback;
               
                return redirect()->to(implode('/', $segments));
            }

            session(['locale' => $segment]);
            app()->setLocale($segment);
        }

        return $next($request);
    }

}