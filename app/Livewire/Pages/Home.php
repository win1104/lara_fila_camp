<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Models\ProductCategory as ProductCategoryModel;
use App\Models\PostCategory as PostCategoryModel;
use App\Models\Post as PostModel;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $menus;
    public $news_cate;
    public $activeTab = 'all';
    public $changeTab = 'all';
    public $works = [];
    public $news_post = [];
    public $activeMenu = null;

    public function mount()
    {
        $this->menus = ProductCategoryModel::where('locale', app()->getLocale())
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

    public function openNewTab($work)
    {
        return $work->url_target == 1 ? '_blank' : '';
    }

    protected function loadPosts()
    {
        $query = ProductModel::where('locale', app()->getLocale())
            ->where('display', 1)
            ->orderBy('order', 'asc')
            ->limit(6);

        if ($this->activeTab === 'all') {
            $menuSlugs = $this->menus->pluck('slug')->toArray();
            $relatedProductIds = DB::table('product_relation')
                ->whereIn('product_category_slug', $menuSlugs)
                ->pluck('product_slug');
            $query->whereIn('slug', $relatedProductIds);
            $this->activeMenu = null;
        }else{
            $relatedProductIds = DB::table('product_relation')
                ->where('product_category_slug', $this->activeTab)
                ->pluck('product_slug');
            $query->whereIn('slug', $relatedProductIds);
            $this->activeMenu = $this->menus->firstWhere('slug', $this->activeTab);
        }

        $this->works = $query->with('product_category', 'images')->get();

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
                // ->where('post_category_id', $this->changeTab)
                ->where('post_category_slug', $this->changeTab)
                // ->pluck('post_id')
                ->pluck('post_slug')
                ->toArray();
            // 如果有符合的 post_id，再加條件
            if (!empty($postIds)) {
                $query->whereIn('slug', $postIds);
            } else {
                // 沒有對應文章，直接設空集合
                $this->news_post = collect();
                return;
            }
        }
        // $this->news_post = $query->with('categories')->get();
        $this->news_post = $query->with('post_category')->get();
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.home');
        // return view('home');
    }
}
