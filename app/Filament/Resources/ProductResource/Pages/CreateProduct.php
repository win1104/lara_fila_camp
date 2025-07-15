<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    // public static function afterCreate(CreateRecord $livewire, Product $record): void
    protected function afterCreate(): void
    {
        // static::moveImagesToSlugFolder($record);
        $this->moveImagesToSlugFolder($this->record);
    }

    public static function moveImagesToSlugFolder(Product $product): void
    {
        $product->load('images'); // 重新抓關聯

        $slug = $product->slug;
        $targetDirectory = "media/products/pics/{$slug}";
        $disk = Storage::disk('public');

        if (!$disk->exists($targetDirectory)) {
            $disk->makeDirectory($targetDirectory);
        }

        foreach ($product->images as $media) {
            $originalPath = $media->path;
            $filename = basename($originalPath);
            $newPath = "{$targetDirectory}/{$filename}";

            // 若來源已在目的地，則略過
            if ($originalPath === $newPath) {
                continue;
            }

            // if ($disk->exists($originalPath) && !$disk->exists($newPath)) {
            //     $disk->move($originalPath, $newPath);
            //     $media->update([
            //         'directory' => $targetDirectory,
            //         'path' => $newPath,
            //     ]);
            // }
            if ($disk->exists($originalPath)) {
                // 若新路徑不存在，複製一份
                if (!$disk->exists($newPath)) {
                    $disk->copy($originalPath, $newPath);
                }

                // 更新圖片資料
                $media->update([
                    'directory' => $targetDirectory,
                    'path' => $newPath,
                ]);
            }
        }
    }
}
