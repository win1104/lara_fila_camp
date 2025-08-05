<?php

namespace App\Providers;

use App\Filament\Tiptap\Stats;
use App\Filament\Tiptap\Carousel;
use App\Filament\Tiptap\LtextRimage;
use App\Filament\Tiptap\T_img_b_text;
use App\Filament\Tiptap\Four_card;
use App\Filament\Tiptap\Full_bg;
use App\Filament\Tiptap\Full_youtube;
use App\Filament\Tiptap\Member_card;
use App\Filament\Tiptap\Step;
use App\Filament\Tiptap\Accordion;
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
                    Four_card::class,
                    Full_bg::class,
                    Full_youtube::class,
                    Member_card::class,
                    Step::class,
                    Accordion::class,
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
