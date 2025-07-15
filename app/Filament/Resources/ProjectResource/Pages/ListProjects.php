<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use App\Models\ProductCategory;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $view = 'filament.resources.project-resource.pages.list-projects';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public ?string $activeTab = 'all'; // 預設值

    public function setActiveTab($tabKey)
    {
        $this->activeTab = $tabKey;
        $this->resetPage(); // 切換時重置分頁
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('全部產品')
                ->icon('heroicon-o-shopping-bag'),
        ];

        $productCategories = ProductCategory::where('parent_slug', 'tarvelgroups')->get();

        foreach ($productCategories as $category) {
            $tabs[$category->slug] = Tab::make($category->title)
                ->icon('heroicon-o-tag')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('parent_slug', $category->slug));
        }

        // $tabs['published'] = Tab::make('上架')
        //     ->icon('heroicon-o-check-circle')
        //     ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1));
        // $tabs['unpublished'] = Tab::make('下架')
        //     ->icon('heroicon-o-x-circle')
        //     ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0));
        $tabs['recent'] = Tab::make('最近更新')
            ->icon('heroicon-o-clock')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7)));

        return $tabs;
    }
}
