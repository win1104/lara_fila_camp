<?php

namespace App\View\Components\Filament\Resources;

use Illuminate\View\Component;

class RelationManager extends Component
{
    public function render()
    {
        return view('filament.relation-managers.posts-relation-manager'); // 例如 'filament.relation-managers.custom-relation-manager'
    }
}
