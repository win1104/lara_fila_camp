<?php

if (!function_exists('localized_url')) {
    function localized_url(string $targetLocale): string
    {
        $segments = request()->segments(); // 例如 ['tw', 'news']
        $currentLocale = app()->getLocale();

        // 如果第一段是語系代碼就移除
        if (in_array($segments[0] ?? '', ['tw', 'en'])) {
            array_shift($segments);
        }

        // 組回新的網址
        return '/' . $targetLocale . '/' . implode('/', $segments);
    }
}
