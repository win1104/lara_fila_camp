<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');
        $allowedLocales = ['en', 'zh_TW'];

        // 檢查是否有語系參數，如果沒有就使用預設語系
        if (empty($locale))
        {
            $locale = config('app.fallback_locale');
            return redirect("/{$locale}");
        }

        // 檢查語系是否在允許的列表中
        if (! in_array($locale, $allowedLocales))
        {
            $locale = config('app.fallback_locale');
            return redirect("/{$locale}");
        }

        // 設定應用程式的語言環境
        App::setLocale($locale);

        // 設定系統層級的語言環境
        $localeMap = [
            'en' => 'en_US.UTF-8',
            'zh_TW' => 'zh_TW.UTF-8'
        ];

        $systemLocale = $localeMap[$locale] ?? 'en_US.UTF-8';
        setlocale(LC_ALL, $systemLocale);

        return $next($request);
    }
}
