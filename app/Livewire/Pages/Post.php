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
        $this->type = $type;

        if ($post instanceof PostModel)
        {
            // 詳細頁：路由模型繫結已成功，將 post 物件賦值給 public 屬性
            $this->post = $post;
        } else {
            // 列表頁：沒有 post 物件，我們需要查詢該分類下的所有文章
            // 注意：這裡的 $menu 是從 URL 傳入的 slug 字串，不是物件
            $this->posts = PostModel::with('categories')
                ->where('menu_slug', $menu)
                ->where('locale', app()->getLocale())
                ->where('display', 1)
                ->orderBy('order', 'asc')
                ->get();

            // 只有在列表頁且找不到任何文章時，才顯示 404
            // if ($this->posts->isEmpty()) {
            //     abort(404);
            // }
        }
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        return view('livewire.pages.post', [
            'menuType' => $this->type
        ]);
    }
}
