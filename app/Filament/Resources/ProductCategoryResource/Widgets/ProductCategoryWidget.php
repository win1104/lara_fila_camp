<?php

namespace App\Filament\Resources\ProductCategoryResource\Widgets;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\LinkAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class ProductCategoryWidget extends BaseWidget
{
    protected static string $model = ProductCategory::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = '產品類別（樹狀模式）';

    protected bool $enableTreeTitle = true;


    protected function getFormSchema(): array
    {
        return [
            TextInput::make('locale')
                ->default(app()->getLocale())
                ->disabled(),
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignorable: fn ($record) => $record),
        ];
    }

    // INFOLIST, CAN DELETE
    public function getViewFormSchema(): array {
        return [
            //
        ];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     // return null;
    //     return 'heroicon-o-cake';
    // }

    protected function getActions(): array
    {
        return [
            Action::make('編輯網頁內容')
                ->url(fn (?ProductCategory $record) => $record
                    ? route('filament.admin.resources.product-categories.edit', ['record' => $record->slug])
                    : null,
                    shouldOpenInNewTab: false)
                ->defaultView(Action::LINK_VIEW)
                ->icon('heroicon-o-bars-4'),
            // LinkAction::make(),
                // EditAction::make(),
            // DeleteAction::make(),
            // EditAction::make()->color('gray'),
            // ActionGroup::make([
            //     ViewAction::make(),
            //     EditAction::make(),
            //     DeleteAction::make(),
            // ]),

        ];
    }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    // protected function getTreeActions(): array
    // {
    //     return [
    //         Action::make('編輯內容')
    //             // ->url(fn () => route('filament.admin.resources.articles.index'),false)
    //             // ->url(fn () => route('filament.admin.resources.articles.edit', ['record' => 1]), false)
    //             ->url(fn () => route('filament.admin.resources.patients.edit', ['record' => 2]), false)

    //             // ->action(function () {
    //             //     // $this->getRecordTitle();
    //             //     Notification::make()->success()->title('Hello World')->send();
    //             // })
    //             ->defaultView(Action::LINK_VIEW)
    //             ->icon('heroicon-o-bars-4'),
    //         // LinkAction::make(),
    //         ViewAction::make(),
    //         EditAction::make(),
    //         // ActionGroup::make([

    //         //     ViewAction::make(),
    //         //     EditAction::make(),
    //         // ]),
    //         DeleteAction::make(),
    //     ];
    // }

    // OR OVERRIDE FOLLOWING METHODS
    //protected function hasDeleteAction(): bool
    //{
    //    return true;
    //}
    //protected function hasEditAction(): bool
    //{
    //    return true;
    //}
    //protected function hasViewAction(): bool
    //{
    //    return true;
    //}

    # Record Title
    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (! $record) {
            return '';
        }

        $display = $record->display ? '✓' : '✗';
        $color = $record->display ? 'text-success-500' : 'text-danger-500';


        return "<span class='$color mr-2'> $display </span>
            {$record->title}
            <div class='inline-block bg-gray-100 ml-2 px-3 py-1 rounded-md text-xs text-gray-600 font-light'>{$record->slug}</div>"
            ;
    }

    public function getParentKey(?Model $record = null): ?string
    {
        if (!$record) {
            return ProductCategory::defaultParentKey();
        }
        return $record->parent_slug;
    }

    public function getRecordKey(?Model $record = null): string
    {
        if (!$record) {
            return '';
        }
        return $record->slug;
    }

    protected function getTreeQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $locale = app()->getLocale();
        $routeLocale = request()->route('locale');
        $actualLocale = $routeLocale ?: $locale;

        // \Illuminate\Support\Facades\Log::info('ProductCategoryWidget getTreeQuery:', [
        //     'app_locale' => $locale,
        //     'route_locale' => $routeLocale,
        //     'actual_locale' => $actualLocale,
        //     'count' => static::getModel()::where('locale', $actualLocale)->count(),
        //     'sample_records' => static::getModel()::where('locale', $actualLocale)->take(3)->get(['slug', 'title', 'locale'])->toArray()
        // ]);

        return static::getModel()::query()
            ->where('locale', $actualLocale)
            ->orderBy('order');
    }

    public function getRootLayerRecords(): \Illuminate\Support\Collection
    {
        $locale = app()->getLocale();
        $routeLocale = request()->route('locale');

        // 如果是 Livewire 請求，從 referer 中提取語言
        if (!$routeLocale && request()->header('Referer')) {
            $refererPath = parse_url(request()->header('Referer'), PHP_URL_PATH);
            if (preg_match('/^\/([a-z]{2})\//', $refererPath, $matches)) {
                $routeLocale = $matches[1];
            }
        }

        // 如果 route locale 和 app locale 不一致，使用 route locale
        $actualLocale = $routeLocale ?: $locale;

        $records = static::getModel()::query()
            ->where('locale', $actualLocale)
            ->where('parent_slug', ProductCategory::defaultParentKey())
            ->orderBy('order')
            ->get();

        \Illuminate\Support\Facades\Log::info('ProductCategoryWidget getRootLayerRecords:', [
            'app_locale' => $locale,
            'route_locale' => $routeLocale,
            'actual_locale' => $actualLocale,
            'request_url' => request()->url(),
            'referer' => request()->header('Referer'),
            'route_parameters' => request()->route() ? request()->route()->parameters() : null,
            'default_parent_key' => ProductCategory::defaultParentKey(),
            'count' => $records->count(),
            'records' => $records->map(function($item) {
                return [
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'locale' => $item->locale,
                    'parent_slug' => $item->parent_slug
                ];
            })->toArray()
        ]);

        return $records;
    }

    public function updateTree(?array $list = null): array
    {
        Log::info('Tree Update Data:', ['data' => $list]);

        if (!$list) {
            return $this->getTreeData();
        }

        try {
            DB::beginTransaction();

            $this->processTreeItems($list);

            DB::commit();

            Notification::make()
                ->title('選單結構已更新')
                ->success()
                ->send();

            return $this->getTreeData();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tree Update Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->title('更新失敗')
                ->danger()
                ->send();

            throw $e;
        }
    }

    protected function processTreeItems(array $items, $parentSlug = null): void
    {
        foreach ($items as $index => $item) {
            $this->processTreeItem($item, $parentSlug, $index + 1);

            if (!empty($item['children'])) {
                $this->processTreeItems($item['children'], $item['id']);
            }
        }
    }

    protected function processTreeItem(array $item, $parentSlug = null, int $order = 1): void
    {
        $slug = $item['id'];
        $record = static::getModel()::where('slug', $slug)->first();

        if (!$record) {
            Log::warning('Record not found:', ['slug' => $slug]);
            return;
        }

        $record->forceFill([
            'parent_slug' => $parentSlug ?? ProductCategory::defaultParentKey(),
            'order' => $order,
            'updated_at' => now(),
        ])->save();

        Log::info('Processed tree item:', [
            'slug' => $slug,
            'parent_slug' => $record->parent_slug,
            'order' => $order
        ]);
    }

    //排序儲存後重新抓資料
    protected function getTreeData(): array
    {
        $items = $this->getRootLayerRecords();

        \Illuminate\Support\Facades\Log::info('ProductCategoryWidget getTreeData:', [
            'locale' => app()->getLocale(),
            'root_items_count' => $items->count(),
            'root_items' => $items->map(function($item) {
                return [
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'locale' => $item->locale,
                    'parent_slug' => $item->parent_slug
                ];
            })->toArray()
        ]);

        return $this->transformItems($items);
    }

    protected function transformItems($items): array
    {
        $result = [];
        foreach ($items as $item) {
            // 現在可以直接使用 model 的 children 關聯，因為已經包含語言過濾
            $children = $item->children;

            \Illuminate\Support\Facades\Log::info('ProductCategoryWidget transformItems:', [
                'parent_slug' => $item->slug,
                'parent_title' => $item->title,
                'parent_locale' => $item->locale,
                'children_count' => $children->count(),
                'children' => $children->map(function($child) {
                    return [
                        'slug' => $child->slug,
                        'title' => $child->title,
                        'locale' => $child->locale,
                        'parent_slug' => $child->parent_slug
                    ];
                })->toArray()
            ]);

            $result[] = [
                'id' => $item->slug,
                'parent' => $item->parent_slug === ProductCategory::defaultParentKey() ? -1 : $item->parent_slug,
                'order' => $item->order,
                'title' => $this->getTreeRecordTitle($item),
                'children' => $this->transformItems($children),
            ];
        }
        return $result;
    }
}
