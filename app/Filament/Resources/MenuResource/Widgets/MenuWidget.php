<?php

namespace App\Filament\Resources\MenuResource\Widgets;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MenuWidget extends BaseWidget
{
    protected static string $model = Menu::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = '網站架構（樹狀模式）';

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

    public function getViewFormSchema(): array {
        return [
            //
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('編輯網頁內容')
                ->url(fn (?Menu $record) => route('filament.admin.resources.menus.edit', ['record' => $record ? $record->slug : null]), shouldOpenInNewTab: false)
                ->defaultView(Action::LINK_VIEW)
                ->icon('heroicon-o-bars-4'),
        ];
    }

    protected function getTreeActions(): array
    {
        return $this->getActions();
    }

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (! $record) {
            return '';
        }
        return "[{$record->slug}] {$record->title}";
    }

    protected function getParentField(): string
    {
        return 'parent_slug';
    }

    protected function getOrderField(): string
    {
        return 'order';
    }

    protected function getChildrenRelationship(): string
    {
        return 'children';
    }

    public function getParentKey(?Model $record = null): ?string
    {
        if (!$record) {
            return Menu::defaultParentKey();
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
        return static::getModel()::query()
            ->where('locale', app()->getLocale())
            ->orderBy($this->getOrderField());
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
            'parent_slug' => $parentSlug ?? Menu::defaultParentKey(),
            'order' => $order,
            'updated_at' => now(),
        ])->save();

        Log::info('Processed tree item:', [
            'slug' => $slug,
            'parent_slug' => $record->parent_slug,
            'order' => $order
        ]);
    }

    protected function getRecordId($record): string
    {
        return $record->slug;
    }

    protected function getRecordParentId($record): string
    {
        return $record->parent_slug;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Log::info('Record Update:', [
            'record' => $record->toArray(),
            'data' => $data
        ]);

        if (isset($data['parent_id'])) {
            $data['parent_slug'] = $data['parent_id'] === -1
                ? Menu::defaultParentKey()
                : $data['parent_id'];
            unset($data['parent_id']);
        }

        $record->forceFill($data)->save();
        return $record;
    }

    protected function handleRecordCreation(array $data): Model
    {
        Log::info('Record Creation:', ['data' => $data]);

        if (isset($data['parent_id'])) {
            $data['parent_slug'] = $data['parent_id'] === -1
                ? Menu::defaultParentKey()
                : $data['parent_id'];
            unset($data['parent_id']);
        }

        return static::getModel()::create($data);
    }

    protected function getTreeData(): array
    {
        $items = $this->getRootLayerRecords();
        return $this->transformItems($items);
    }

    protected function transformItems($items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'id' => $item->slug,
                'parent' => $item->parent_slug === Menu::defaultParentKey() ? -1 : $item->parent_slug,
                'order' => $item->order,
                'title' => $this->getTreeRecordTitle($item),
                'children' => $this->transformItems($item->children),
            ];
        }
        return $result;
    }

    public function onSortOrderChanged($data): void
    {
        Log::info('Sort Order Changed:', ['data' => $data]);

        try {
            DB::beginTransaction();

            $record = static::getModel()::where('slug', $data['id'])->first();

            if ($record) {
                // 更新當前記錄的順序
                $record->forceFill([
                    'order' => $data['order'],
                    'updated_at' => now(),
                ])->save();

                // 更新同層級的其他記錄順序
                $siblings = static::getModel()::query()
                    ->where('parent_slug', $record->parent_slug)
                    ->where('slug', '!=', $record->slug)
                    ->orderBy('order')
                    ->get();

                $order = 1;
                foreach ($siblings as $sibling) {
                    if ($order == $data['order']) {
                        $order++;
                    }
                    if ($sibling->order != $order) {
                        $sibling->forceFill([
                            'order' => $order,
                            'updated_at' => now(),
                        ])->save();
                    }
                    $order++;
                }

                Log::info('Updated orders:', [
                    'current' => [
                        'slug' => $record->slug,
                        'order' => $record->order
                    ],
                    'siblings' => $siblings->pluck('order', 'slug')
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sort Order Update Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function onMoved($data): void
    {
        Log::info('Node Moved:', ['data' => $data]);

        try {
            DB::beginTransaction();

            $record = static::getModel()::where('slug', $data['id'])->first();

            if ($record) {
                $parentSlug = ($data['parent'] ?? -1) === -1
                    ? Menu::defaultParentKey()
                    : $data['parent'];

                // 更新當前記錄
                $record->forceFill([
                    'parent_slug' => $parentSlug,
                    'order' => $data['order'] ?? 1,
                    'updated_at' => now(),
                ])->save();

                // 更新舊位置的同層級記錄順序
                $oldSiblings = static::getModel()::query()
                    ->where('parent_slug', $record->getOriginal('parent_slug'))
                    ->where('slug', '!=', $record->slug)
                    ->orderBy('order')
                    ->get();

                $order = 1;
                foreach ($oldSiblings as $sibling) {
                    $sibling->forceFill([
                        'order' => $order,
                        'updated_at' => now(),
                    ])->save();
                    $order++;
                }

                // 更新新位置的同層級記錄順序
                if ($record->getOriginal('parent_slug') !== $parentSlug) {
                    $newSiblings = static::getModel()::query()
                        ->where('parent_slug', $parentSlug)
                        ->where('slug', '!=', $record->slug)
                        ->orderBy('order')
                        ->get();

                    $order = 1;
                    foreach ($newSiblings as $sibling) {
                        if ($order == $record->order) {
                            $order++;
                        }
                        $sibling->forceFill([
                            'order' => $order,
                            'updated_at' => now(),
                        ])->save();
                        $order++;
                    }
                }

                Log::info('Updated position:', [
                    'record' => [
                        'slug' => $record->slug,
                        'parent_slug' => $record->parent_slug,
                        'order' => $record->order
                    ],
                    'old_siblings' => $oldSiblings->pluck('order', 'slug'),
                    'new_siblings' => isset($newSiblings) ? $newSiblings->pluck('order', 'slug') : null
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Move Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
