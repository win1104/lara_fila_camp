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
    public $isDetail = false; // 每頁顯示數量

    public function mount($product = null)
    {
        // 確保初始值設定
        if ($product)
        {
            // 單一產品詳情頁面

            // 使用 with('images') 預先載入與 media 的圖片關聯，避免 N+1 問題
            $this->product = ProductModel::with('images')
                ->where('locale', app()->getLocale())
                ->where('slug', $product->slug)
                ->where('display', 1)
                ->firstOrFail();

            if (!$this->product) {
                abort(404);
            }

            $this->isDetail = true;
        }
        else
        {
            // 產品列表頁面
            $this->products = ProductModel::where('locale', app()->getLocale())
                ->where('display', 1)
                ->orderBy('order', 'asc')
                ->get();

            // if (!$this->products) {
            //     abort(404);
            // }
        }
    }

    #[Layout('layouts.app')] //for PHP 8（Attribute）, 使用 layouts/app.blade.php 作為布局
    public function render():View
    {
        return view('livewire.pages.product', [
            'isDetail' => $this->isDetail
        ]);
    }

    /**
     * 重設分頁，以便搜尋時總是從第一頁開始
     */
    // public function updatingSearch()
    // {
    //     $this->resetPage();
    // }
}
