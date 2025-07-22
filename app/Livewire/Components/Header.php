<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;
use App\Models\Menu as MenuModel;
use App\Models\ProductCategory;

class Header extends Component
{
    // public bool $responsiveMenu = false;
    // public ?MenuModel $menus = null;
    public $menus;
    public $productCategory;

    public function mount()
    {
        $this->menus = MenuModel::where('locale', app()->getLocale())
            ->where('parent_slug', 'home')
            ->where('display', 1)
            ->limit(8)
            ->orderBy('order', 'asc')
            ->get();



        // $this->productCategory = ProductCategory::where('locale', app()->getLocale())
        //     ->where('parent_slug', 'home')
        //     ->where('display', 1)
        //     ->limit(8)
        //     ->orderBy('order', 'asc')
        //     ->get();

        // $this->productCategory = ProductCategory::where('locale', app()->getLocale())
        //     ->where('parent_slug', 'home')
        //     ->where('display', 1)
        //     ->limit(8)
        //     ->orderBy('order', 'asc')
        //     ->get();
        // dd($this->productCategory);
    }

    // public function toggleDrawer()
    // {
    //     $this->responsiveMenu = !$this->responsiveMenu;
    // }

    public function render()
    {
        return view('livewire.components.header');
    }
}
