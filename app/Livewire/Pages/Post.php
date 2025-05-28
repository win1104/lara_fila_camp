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

    public function mount($type, $menu)
    {
        // \Illuminate\Support\Facades\Log::info('Post Component Mount:', [
        //     'type' => $type,
        //     'menu' => $menu,
        //     'locale' => app()->getLocale(),
        //     'route' => request()->route()->getName(),
        //     'parameters' => request()->route()->parameters()
        // ]);

        if ($type === 'post')
        {
            // 如果是單一文章模式
            $this->post = PostModel::where('menu_slug', $menu)
                ->where('locale', app()->getLocale())
                ->where('display', 1)
                ->limit(1)
                ->first();

            if (!$this->post) {
                abort(404);
            }
        }
        else
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
            $this->posts->transform(function ($post) {
                $post->content = Str::limit(strip_tags($post->content), 100);
                return $post;
            });
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
