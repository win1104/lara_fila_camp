<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Models\Menu as MenuModel;
use App\Models\PostCategory as PostCategoryModel;
use App\Models\Post as PostModel;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $menus;
    public $news_cate;
    public $activeTab = 'all';
    public $changeTab = 'all';
    public $works = [];
    public $news_post = [];

    public function mount()
    {
        $this->menus = MenuModel::where('locale', app()->getLocale())
            ->where('display', 1)
            ->where('parent_slug', 'works')
            ->orderBy('order', 'asc')
            ->get();

        $this->loadPosts();

        $this->news_cate = PostCategoryModel::where('locale', app()->getLocale())
            ->where('display', 1)
            // ->where('slug', 'works')
            ->orderBy('order', 'asc')
            ->get();
        $this->loadNews();

    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadPosts();
    }

    public function newsTab($tab_id)
    {
        $this->changeTab = $tab_id;
        $this->loadNews();
    }

    protected function loadPosts()
    {
        $query = PostModel::where('locale', app()->getLocale())
            // ->where('slug', 'works')
            ->where('display', 1)
            ->orderBy('order', 'asc');
            // ->limit(4);

        if ($this->activeTab === 'all') {
            $menuSlugs = $this->menus->pluck('slug')->toArray();
            $query->whereIn('menu_slug', $menuSlugs);
            $this->activeMenu = null;
        }else{
            $query->where('menu_slug', $this->activeTab);
            $this->activeMenu = $this->menus->firstWhere('slug', $this->activeTab);
        }

        $this->works = $query->with('menu')->get();

        // dd($this->menus);
    }

    protected function loadNews()
    {
        $query = PostModel::where('locale', app()->getLocale())
            ->where('menu_slug', 'news')
            ->where('display', 1)
            ->orderBy('order', 'asc')
            ->limit(4);

        if ($this->changeTab !== 'all') {
            $postIds = DB::table('post_relation')
                ->where('post_category_id', $this->changeTab)
                ->pluck('post_id')
                ->toArray();
            // 如果有符合的 post_id，再加條件
            if (!empty($postIds)) {
                $query->whereIn('id', $postIds);
            } else {
                // 沒有對應文章，直接設空集合
                $this->news_post = collect();
                return;
            }
        }

        $this->news_post = $query->with('categories')->get();

    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.home');
        // return view('home');
    }
}
