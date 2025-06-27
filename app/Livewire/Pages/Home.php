<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Models\Menu as MenuModel;
use App\Models\Post as PostModel;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $menus;
    public $activeTab = 'all';
    public $works = [];

    public function mount()
    {
        $this->menus = MenuModel::where('locale', app()->getLocale())
            ->where('display', 1)
            ->where('parent_slug', 'works')
            ->orderBy('order', 'asc')
            ->get();

        $this->loadPosts();

        // return static::where('slug', $value)
        //     ->where('locale', app()->getLocale())
        //     ->firstOrFail();

    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadPosts();
    }

    protected function loadPosts()
    {
        $query = PostModel::where('locale', app()->getLocale())
            ->where('menu_slug', 'works')
            ->where('display', 1)
            ->orderBy('order', 'asc');
            // ->limit(4);

        if ($this->activeTab !== 'all') {
            $this->works->where('slug', $this->activeTab);
        }

        $this->works = $query->get();

    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.home');
        // return view('home');
    }
}
