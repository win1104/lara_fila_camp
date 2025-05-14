<?php

namespace App\Filament\Resources\MenuResource\Widgets;

use App\Models\Menu;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class MenuWidget extends BaseWidget
{
    protected static string $model = Menu::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = '樹狀模式';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
            TextInput::make('slug'),
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
    //     return null;
    // }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    protected function getTreeActions(): array
    {
        return [
            Action::make('編輯網頁內容')
                // ->url(fn () => route('filament.admin.resources.articles.index'),false)
                ->url(fn (?Menu $record) => route('filament.admin.resources.menus.edit', ['record' => $record ? $record->id : null]), shouldOpenInNewTab: false)

                // ->action(function () {
                //     // $this->getRecordTitle();
                //     Notification::make()->success()->title('Hello World')->send();
                // })
                ->defaultView(Action::LINK_VIEW)
                ->icon('heroicon-o-bars-4'),
            // LinkAction::make(),
            ActionGroup::make([

                ViewAction::make(),
                EditAction::make(),
            ]),
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