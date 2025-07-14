<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductResource;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.list-products';

    public ?string $activeTab = 'all'; // 預設值

    public function setActiveTab($tabKey)
    {
        $this->activeTab = $tabKey;
    }


    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('全部產品')
                ->icon('heroicon-o-shopping-bag'),
        ];

        $productCategories = ProductCategory::where('parent_slug', 'works')->get();

        foreach ($productCategories as $category) {
            $tabs[$category->slug] = Tab::make($category->title)
                ->icon('heroicon-o-tag')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('product_category', function (Builder $query) use ($category) {
                    $query->where('slug', $category->slug);
                }));
        }

        $tabs['published'] = Tab::make('上架')
            ->icon('heroicon-o-check-circle')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1));
        $tabs['unpublished'] = Tab::make('下架')
            ->icon('heroicon-o-x-circle')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0));
        $tabs['recent'] = Tab::make('最近更新')
            ->icon('heroicon-o-clock')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7)));

        return $tabs;
    }

    public function getCurrentTabLabel(): string
    {
        $tabs = $this->getTabs();
        return $tabs[$this->activeTab]->getLabel() ?? '全部產品';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
