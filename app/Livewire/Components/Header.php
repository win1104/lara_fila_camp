<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;

class Header extends Component
{
    public bool $responsiveMenu = false;

    public function toggleDrawer()
    {
        $this->responsiveMenu = !$this->responsiveMenu;
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
