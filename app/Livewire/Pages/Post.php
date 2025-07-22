<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post as PostModel;
use Illuminate\Support\Str;

class Post extends Component
{
    public ?PostModel $post = null;
    public $posts = null;
    public ?string $slug = null;
    public ?string $type = null;
    public string $activeTab = 'tab-0';

    public function mount($type, $menu, $post = null)
    {
        // \Illuminate\Support\Facades\Log::info('Post Component Mount:', [
        //     'type' => $type,
        //     'menu' => $menu,
        //     'locale' => app()->getLocale(),
        //     'route' => request()->route()->getName(),
        //     'parameters' => request()->route()->parameters()
        // ]);

        if ($type != 'posts')
        {
            // 如果是列表模式，獲取該分類下的所有文章
            $this->posts = PostModel::where('menu_slug', $menu)
                ->where('locale', app()->getLocale())
                ->where('display', 1)
                ->orderBy('order', 'asc')
                ->get();

            if ($this->posts->isEmpty()) {
                abort(404);
            }

            // 處理每個文章的內容長度
            // if ($type != 'tab')
            //     $this->posts->transform(function ($post) {
            //         $post->content = Str::limit(strip_tags($post->content), 100);
            //         return $post;
            // });
        }
        else
        {
            // 如果提供了 posts 參數，直接使用它，for post detail
            if ($post instanceof PostModel) {
                $this->post = $post;
            }
            else
            {
                // 否則通過 menu_slug 查詢，for post by menu slug
                $this->post = PostModel::where('menu_slug', $menu)
                    ->where('locale', app()->getLocale())
                    ->where('display', 1)
                    ->limit(1)
                    ->first();
            }

            // 如果找不到文章，返回 404
            if (!$this->post) {
                abort(404);
            }# code...}
        }

        $this->slug = $menu;
        $this->type = $type;
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        return view('livewire.pages.post', [
            'menuType' => $this->type
        ]);
    }
}
