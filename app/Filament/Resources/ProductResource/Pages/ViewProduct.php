<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ProductResource;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    // public function getSubNavigationPosition(): SubNavigationPosition
    // {
    //     return SubNavigationPosition::Top;
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print')
                ->label('列印')
                ->color('gray')
                ->icon('heroicon-o-printer')
                ->form([
                    Forms\Components\TextInput::make('quantity')
                        ->label(__('quantity'))
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(100),
                    Forms\Components\Radio::make('format')
                        ->label(__('format'))
                        ->options([
                            'dymo'       => __('dymo'),
                            '2x7_price'  => __('2x7_price'),
                            '4x7_price'  => __('4x7_price'),
                            '4x12'       => __('4x12'),
                            '4x12_price' => __('4x12_price'),
                        ])
                        ->default('2x7_price')
                        ->required(),
                ])
                ->action(function (array $data, $record) {
                    // $pdf = PDF::loadView('products::filament.resources.products.actions.print', [
                    //     'records'  => collect([$record]),
                    //     'quantity' => $data['quantity'],
                    //     'format'   => $data['format'],
                    // ]);

                    // $paperSize = match ($data['format']) {
                    //     'dymo'  => [0, 0, 252.2, 144],
                    //     default => 'a4',
                    // };

                    // $pdf->setPaper($paperSize, 'portrait');

                    // return response()->streamDownload(function () use ($pdf) {
                    //     echo $pdf->output();
                    // }, 'Product-'.$record->name.'.pdf');

                    return null;
                }),
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('title'))
                        ->body(__('body')),
                        // ->title(__('products::filament/resources/product/pages/view-product.header-actions.delete.notification.title'))
                        // ->body(__('products::filament/resources/product/pages/view-product.header-actions.delete.notification.body')),
                ),
        ];
    }

    public function getTitle(): string
    {
        return '' . $this->record->title;
    }

    protected function getRedirectUrl(): string
    {
        // 從 session 中獲取頁次信息
        if ($page = session('products_list_page')) {
            session()->forget('products_list_page');
            return static::$resource::getUrl('index', ['page' => $page]);
        }

        // 預設回到第一頁
        return static::$resource::getUrl('index');
    }
}
