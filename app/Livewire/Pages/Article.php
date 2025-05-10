<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Article as ArticleModel;
// use illumminate\v

class Article extends Component
{
    public ?ArticleModel $article = null;
    public $slug;

    public function mount(ArticleModel $articles)
    {
        $this->article = $articles;
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局

    public function render():View
    {
        return view('livewire.pages.article');
    }
}
