<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\Post;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;



    // public static function getTabs(): array
    public function getTabs(): array
    {
        // 基於用戶權限的 Tab
        $tabs = [
            'all' => Tab::make('全部文章')
                ->badge(Post::count())
                ->icon('heroicon-o-document-duplicate'),
            'published' => Tab::make('已發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1))
                ->badge(Post::where('display', 1)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
            'unpublished' => Tab::make('未發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0))
                ->badge(Post::where('display', 0)->count())
                ->badgeColor('gray')
                ->icon('heroicon-o-pencil-square'),
        ];

        if (auth()->user()->can('view_draft_posts')) {
            $tabs['recent'] = Tab::make('最近更新')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7)))
                ->badge(Post::where('updated_at', '>=', now()->subDays(7))->count())
                ->badgeColor('warning');
        }

        if (auth()->user()->can('view_archived_posts')) {
            $tabs['this_month'] = Tab::make('本月發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
                ->badge(Post::whereMonth('created_at', now()->month)->count())
                ->badgeColor('warning');
        }

        return $tabs;


        // 不綁權限的 Tab
        // return [
        //     'all' => Tab::make('全部文章')
        //         ->badge(Post::count())
        //         ->icon('heroicon-o-document-duplicate'),
        //     'published' => Tab::make('已發布')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1))
        //         ->badge(Post::where('display', 1)->count())
        //         ->badgeColor('success')
        //         ->icon('heroicon-o-check-circle'),
        //     'unpublished' => Tab::make('未發布')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0))
        //         ->badge(Post::where('display', 0)->count())
        //         ->badgeColor('gray')
        //         ->icon('heroicon-o-pencil-square'),
        //     'recent' => Tab::make('最近更新')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->where('updated_at', '>=', now()->subDays(7)))
        //         ->badge(Post::where('updated_at', '>=', now()->subDays(7))->count())
        //         ->badgeColor('warning'),
        //     'this_month' => Tab::make('本月發布')
        //         ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
        //         ->badge(Post::whereMonth('created_at', now()->month)->count())
        //         ->badgeColor('warning'),
        // ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
