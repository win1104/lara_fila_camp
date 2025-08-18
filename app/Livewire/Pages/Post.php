<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post as PostModel;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class Post extends Component
{
    public ?PostModel $post = null;
    // public $posts = null;
    public ?string $slug = null;
    public ?string $type = null;
    public string $activeTab = 'tab-0';
    public string $menu;
    public $categories;
    public $selectedCategory = null;

    public function mount($type, $menu, $post = null)
    {
        $this->categories = PostCategory::where('locale', app()->getLocale())
            ->where('display', 1)
            // ->where('slug', '!=', 'home')
            ->orderBy('order')
            ->get();

        $this->type = $type;
        $this->menu = $menu;

        if ($post instanceof PostModel)
        {
            // 詳細頁：路由模型繫結已成功，將 post 物件賦值給 public 屬性
            $this->post = $post;
        }
        // else {
        //     // 列表頁：沒有 post 物件，我們需要查詢該分類下的所有文章
        //     // 注意：這裡的 $menu 是從 URL 傳入的 slug 字串，不是物件
        //     $this->posts = PostModel::with('post_category')
        //         ->where('menu_slug', $menu)
        //         ->where('locale', app()->getLocale())
        //         ->where('display', 1)
        //         ->orderBy('order', 'asc')
        //         ->paginate(10);
        //         // ->get();

        // }
    }

    public function selectCategory($slug = null)
    {
        // $this->selectedCategory = $slug;
        if ($this->selectedCategory === $slug) {
            $this->selectedCategory = null;
        } else {
            $this->selectedCategory = $slug;
        }
        // $this->loadProducts();
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        $posts = null;

        if (!$this->post) {
            $posts = PostModel::with('post_category')
                ->where('menu_slug', $this->menu)
                ->where('locale', app()->getLocale())
                ->where('display', 1)
                ->orderBy('order', 'asc');
                // ->paginate(12);

            if ($this->selectedCategory) {
                $posts->whereHas('post_category', function ($q) {
                    $q->where('slug', $this->selectedCategory);
                });
            }

            $posts = $posts->paginate(12);
        }

        return view('livewire.pages.post', [
            'menuType' => $this->type,
            'posts' => $posts,
        ]);
    }
}
