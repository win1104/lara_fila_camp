<?php

namespace App\Livewire\Components;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public function render()
    {
        return view('livewire.components.language-switcher');
    }

    public function getCurrentLocale()
    {
        return app()->getLocale();
    }

    public function getAvailableLocales()
    {
        return [
            'tw' => '繁體中文',
            'en' => 'English'
        ];
    }
}