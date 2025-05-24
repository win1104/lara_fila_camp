<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class RouteLabel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $label): Response
    {
        // 設置本地化標籤
        $locale = App::getLocale();
        $localizedLabel = trans("navbar.{$label}", [], $locale);

        // 將本地化標籤附加到路由
        // $request->route()->defaults('label', $localizedLabel);
        $request->route()->defaults('label', $localizedLabel);

        return $next($request);
    }
}
