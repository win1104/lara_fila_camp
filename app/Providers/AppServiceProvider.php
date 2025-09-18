<?php

namespace App\Providers;

use App\Filament\Tiptap\Stats;
use App\Filament\Tiptap\Carousel;
use App\Filament\Tiptap\LtextRimage;
use App\Filament\Tiptap\LimageRtext;
use App\Filament\Tiptap\T_img_b_text;
use App\Filament\Tiptap\Four_card;
use App\Filament\Tiptap\Full_bg;
use App\Filament\Tiptap\Full_youtube;
use App\Filament\Tiptap\Member_card;
use App\Filament\Tiptap\Step;
use App\Filament\Tiptap\Accordion;
use App\Filament\Tiptap\Team_noBorder;
use App\Filament\Tiptap\Gallery;
use App\Filament\Tiptap\Gallery_two;
use App\Filament\Tiptap\Card_gallery;
use App\Filament\Tiptap\Card_gallery_two;
use App\Filament\Tiptap\Feature_list;
use App\Filament\Tiptap\Testimonial;
use App\Filament\Tiptap\Travel_imgR;
use App\Filament\Tiptap\Travel_imgB;
use App\Filament\Tiptap\Split_image_text;
use App\Filament\Tiptap\Flip_split_a;
use App\Filament\Tiptap\Flip_split_b;
use App\Filament\Tiptap\Three_panel;
use App\Filament\Tiptap\DualStack_3_2;
use Illuminate\Support\Facades\Blade;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\View\Components\Filament\Resources\RelationManager;
use BladeUI\Icons\Factory;

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
                    // Travel_imgR::class,
                    // Travel_imgB::class,
                    // Stats::class,
                    // Carousel::class,
                    // LtextRimage::class,
                    // LimageRtext::class,
                    // T_img_b_text::class,
                    // Four_card::class,
                    // Full_bg::class,
                    // Full_youtube::class,
                    // Member_card::class,
                    // Step::class,
                    // Accordion::class,
                    // Team_noBorder::class,
                    // Gallery::class,
                    // Gallery_two::class,
                    // Card_gallery::class,
                    // Card_gallery_two::class,
                    // Feature_list::class,
                    // Testimonial::class,
                    Split_image_text::class,
                    Flip_split_a::class,
                    Flip_split_b::class,
                    Three_panel::class,
                    DualStack_3_2::class,
                ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    public function boot(Factory $icons): void
    {
        Model::unguard();
        Blade::component('filament::resources.relation-manager', RelationManager::class);

        $icons->add('default', [
            'path' => resource_path('svg'),
            'prefix' => '',
        ]);
    }
}
