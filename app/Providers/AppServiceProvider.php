<?php

namespace App\Providers;

use App\Filament\Tiptap\Stats;
use App\Filament\Tiptap\Carousel;
use App\Filament\Tiptap\LtextRimage;
use App\Filament\Tiptap\T_img_b_text;
use Illuminate\Support\Facades\Blade;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\View\Components\Filament\Resources\RelationManager;
use Filament\Support\Facades\FilamentIcon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        TiptapEditor::configureUsing(function (TiptapEditor $component) {
            $component
                ->blocks([
                    // BatmanBlock::class,
                    Stats::class,
                    Carousel::class,
                    LtextRimage::class,
                    T_img_b_text::class,
                ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Blade::component('filament::resources.relation-manager', RelationManager::class);

        //  FilamentIcon::register([ // [!code focus]
        //     'custom-icons' => __DIR__.
        //     '/../../resources/svg', // [!code focus]
        // ]); // [!code focus]
    }
}
