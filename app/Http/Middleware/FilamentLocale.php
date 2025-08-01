<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class FilamentLocale
{
    protected $localeMap = [
        'tw' => 'tw',
        // 'tw' => 'zh_TW',
        'en' => 'en',
    ];

    public function handle(Request $request, Closure $next)
    {
        $urlLocale = $request->segment(1);

        if (isset($this->localeMap[$urlLocale])) {
            $systemLocale = $this->localeMap[$urlLocale];

            // 設定 Laravel 的語系
            App::setLocale($systemLocale);
            URL::defaults(['locale' => $systemLocale]);
            // URL::defaults(['locale' => $urlLocale]);

            // 設定 Filament 的語系
            Config::set('app.locale', $systemLocale);
            Config::set('filament.locale', $systemLocale);
            Config::set('app.fallback_locale', $systemLocale);
        }

        return $next($request);
    }
}
