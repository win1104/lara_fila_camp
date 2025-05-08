<?php

namespace App\Filament\Widgets;

use App\Models\ProductCategory;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\LinkAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;
use Filament\Tables\Actions\IconButton;

class ProductCategoryWidget extends BaseWidget
{
    protected static string $model = ProductCategory::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = '產品類別';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
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

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    protected function getTreeActions(): array
    {
        return [
            Action::make('編輯內容')
                // ->url(fn () => route('filament.admin.resources.articles.index'),false)
                // ->url(fn () => route('filament.admin.resources.articles.edit', ['record' => 1]), false)
                ->url(fn () => route('filament.admin.resources.patients.edit', ['record' => 2]), false)

                // ->action(function () {
                //     // $this->getRecordTitle();
                //     Notification::make()->success()->title('Hello World')->send();
                // })
                ->defaultView(Action::LINK_VIEW)
                ->icon('heroicon-o-bars-4'),
            // LinkAction::make(),
            ViewAction::make(),
            EditAction::make(),
            // ActionGroup::make([

            //     ViewAction::make(),
            //     EditAction::make(),
            // ]),
            DeleteAction::make(),
        ];
    }

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
        $id = $record->getKey();
        $title = $record->{(method_exists($record, 'determineTitleColumnName') ? $record->determineTitleColumnName() : 'title')};
        return "[{$id} 上下架] {$title}";
    }
}
