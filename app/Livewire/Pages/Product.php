<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Product as ProductModel; // 引入 Product 模型
// use Livewire\WithPagination; // 引入分頁 Trait

class Product extends Component
{
    // use WithPagination; // 使用分頁功能

    public ?ProductModel $product = null;
    public $products = null;
    public $search = ''; // 用於搜尋功能 (稍後可擴展)
    public $perPage = 10; // 每頁顯示數量

    public function mount($product = null)
    {
        if ($product)
        {
            // 單一產品詳情頁面
            $this->product = ProductModel::where('slug', $product)
                ->where('locale', app()->getLocale())
                ->where('display', 1)
                ->firstOrFail();
        }
        else
        {
            // 產品列表頁面
            $this->products = ProductModel::where('locale', app()->getLocale())
                ->where('display', 1)
                ->orderBy('order', 'asc')
                ->get();

            // $this->products = ProductModel::query()
            //     ->where('display', true)
            //     ->when($this->search, function ($query) {
            //         $query->where(function($q) {
            //             $q->where('title', 'like', '%' . $this->search . '%')
            //               ->orWhere('content', 'like', '%' . $this->search . '%');
            //         });
            //     })
            //     ->orderBy('order', 'asc')
            //     ->paginate($this->perPage);
        }
        // dd($this->products);
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        // dd($this->products);
        // return view('livewire.pages.product');
        return view('livewire.pages.product', [
            'perPage' => $this->perPage,
        ]);
    }

    /**
     * 重設分頁，以便搜尋時總是從第一頁開始
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
