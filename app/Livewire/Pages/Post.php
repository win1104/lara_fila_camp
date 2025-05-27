<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post as PostModel;

class Post extends Component
{
    public ?PostModel $post = null;
    public ?string $slug = null;

    public function mount($menu)
    {
        \Illuminate\Support\Facades\Log::info('Post Component Mount:', [
            'menu' => $menu,
            'locale' => app()->getLocale(),
            'route' => request()->route()->getName(),
            'parameters' => request()->route()->parameters()
        ]);

        $this->post = PostModel::where('menu_slug', $menu)
            ->where('locale', app()->getLocale())
            ->where('display', 1)
            ->first();

        if (!$this->post) {
            abort(404);
        }

        $this->slug = $this->post->menu_slug;
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        return view('livewire.pages.post');
    }
}
