<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class Aiing extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.aiing');
    }
}
