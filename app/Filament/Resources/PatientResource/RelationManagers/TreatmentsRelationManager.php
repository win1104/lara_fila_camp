<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TreatmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpan('full')
                    ->visible(fn () => $this->getOwnerRecord()?->type !== 'rabbit'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('€')
                    ->maxValue(42949672.95)
                    ->visible(fn () => in_array($this->getOwnerRecord()?->type, ['cat', 'dog'])),
                Forms\Components\Select::make('treatment_type')
                    ->options(function () {
                        $patient = $this->getOwnerRecord();

                        return match($patient->type) {
                            'cat' => [
                                'vaccination' => '疫苗接種',
                                'checkup' => '健康檢查',
                                'surgery' => '手術',
                            ],
                            'dog' => [
                                'vaccination' => '疫苗接種',
                                'checkup' => '健康檢查',
                                'surgery' => '手術',
                                'grooming' => '美容',
                            ],
                            'rabbit' => [
                                'checkup' => '健康檢查',
                                'dental' => '牙齒護理',
                            ],
                            default => [
                                'checkup' => '健康檢查',
                            ],
                        };
                    })
                    ->required()
                    ->visible(fn () => $this->getOwnerRecord() !== null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->heading('病患資料')
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->reorderable('id') // 啟用拖拉排序功能
            ->defaultSort('id') // 預設按 sort_order 排序
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getHeaderActions(): array
    {
        return [
            // 將 tabs 作為 header actions
            Action::make('tabs')
                // ->view('filament.components.custom-tabs')
                ->extraAttributes(['class' => 'w-full']),
        ];

        // return $this->table(new \Filament\Tables\Table($this))->getHeaderActions();
    }

    public function getTabs(): array
    {
        $ownerRecord = $this->getOwnerRecord();

        // dd($ownerRecord);
        // 基於用戶權限的 Tab
        $tabs = [
            'all' => Tab::make('全部文章')
                ->badge($ownerRecord->treatments()->count())
                // ->badge(Post::count())
                ->icon('heroicon-o-document-duplicate'),
            'published' => Tab::make('已發布')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 1))
                // ->badge($ownerRecord->treatments()->where('display', 1)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
            // 'unpublished' => Tab::make('未發布')
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('display', 0))
            //     // ->badge($ownerRecord->treatments()->where('display', 0)->count())
            //     ->badgeColor('gray')
            //     ->icon('heroicon-o-x-circle'),
        ];
        return $tabs;
    }
}
