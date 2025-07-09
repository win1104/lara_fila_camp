<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
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
        return [
            'all' => Tab::make('全部商品')
                ->icon('heroicon-o-shopping-bag')
                //使用快取來優化徽章計數
                ->badge(fn () => cache()->remember('products.all.count', 300, fn () => Product::count())),
                // ->badge(fn () => Product::count()),

            'active' => Tab::make('上架中')
                ->icon('heroicon-o-check-circle')
                //使用快取來優化徽章計數
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'active'))
                ->badge(fn () => cache()->remember('products.published.count', 300, fn () => Product::where('display', '1')->count()))
                // ->badge(fn () => Product::where('display', '1')->count())
                ->badgeColor('success'),

            'inactive' => Tab::make('下架')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'inactive'))
                ->badge(fn () => Product::where('display', '0')->count())
                ->badgeColor('danger'),

            'out_of_stock' => Tab::make('缺貨')
                ->icon('heroicon-o-exclamation-triangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'out_of_stock'))
                ->badge(fn () => Product::where('check', '1')->count())
                // ->badge(fn () => Product::where('status', 'out_of_stock')->count())
                ->badgeColor('warning'),

            'featured' => Tab::make('精選商品')
                ->icon('heroicon-o-star')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_featured', true))
                ->badge(fn () => Product::where('tag', 'is_featured')->count())
                ->badgeColor('info'),

            'recent' => Tab::make('最近新增')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(7)))
                ->badge(fn () => Product::where('created_at', '>=', now()->subDays(7))->count()),
        ];
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
