<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Models\Article as ArticleModel;

class Home extends Component
{
    public $articles;

    public function mount()
    {
        $this->articles = ArticleModel::where('locale', app()->getLocale())->limit(8)->orderBy('sort', 'asc')->get();


        // return static::where('slug', $value)
        //     ->where('locale', app()->getLocale())
        //     ->firstOrFail();



    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.home');
    }
}
