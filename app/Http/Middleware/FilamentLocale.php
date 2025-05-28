<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class FilamentLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);

        if (in_array($locale, ['en', 'tw'])) {
            App::setLocale($locale);
            URL::defaults(['locale' => $locale]); // 加入這行，設定預設路由參數
        }

        return $next($request);
    }
}
