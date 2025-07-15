<?php

namespace App\Filament\Resources\ProductOptionResource\Pages;

use App\Filament\Resources\ProductOptionResource;
use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Navigation\NavigationItem;
use Filament\Actions\CreateAction;

class ListProductOptions extends ListRecords
{
    public ?Product $product = null;
    protected static string $resource = ProductOptionResource::class;

    public function mount(): void
    {
        $productSlug = request()->query('record');
        $this->product = Product::where('slug', $productSlug)->firstOrFail();

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            /* 開新頁面 */
            // CreateAction::make()
            //     ->url(fn (): string => ProductOptionResource::getUrl('create', ['product_slug' => $this->product->slug])),

            /* fancybox 彈出視窗 */
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['product_slug'] = $this->product->slug;
                    $data['admin_id'] = auth()->id();
                    return $data;
                }),
        ];
    }

    public function getSubNavigation(): array
    {
        if (is_null($this->product)) {
            return [];
        }

        $record = $this->product;

        return [
            NavigationItem::make(ProductResource\Pages\ViewProduct::getNavigationLabel())
                ->icon('heroicon-o-eye')
                ->url(ProductResource\Pages\ViewProduct::getUrl(['record' => $record]))
                ->isActiveWhen(fn () => false),

            NavigationItem::make(ProductResource\Pages\EditProduct::getNavigationLabel())
                ->icon('heroicon-o-pencil-square')
                ->url(ProductResource\Pages\EditProduct::getUrl(['record' => $record]))
                ->isActiveWhen(fn () => false),

            NavigationItem::make('產品規格')
                ->icon('heroicon-o-rectangle-stack')
                ->url(ProductOptionResource::getUrl('index', ['record' => $record]))
                ->isActiveWhen(fn () => true),
        ];
    }

    protected function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('product_slug', $this->product->slug);
    }
}
