<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectSalesResource\Pages;
use App\Filament\Resources\ProjectSalesResource\RelationManagers;
use App\Models\ProjectSales;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectSalesResource extends Resource
{
    protected static ?string $model = ProjectSales::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModelLabel(): string
    {
        return __('product.sales');
    }
    public static function getModelPluralLabel(): string
    {
        return __('product.sales');
    }
    public static function getNavigationLabel(): string
    {
        return __('product.sales');
    }
    protected static ?string $navigationGroup = 'Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('backstage.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('backstage.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backstage.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('backstage.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backstage.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectSales::route('/'),
            'create' => Pages\CreateProjectSales::route('/create'),
            'edit' => Pages\EditProjectSales::route('/{record}/edit'),
        ];
    }
}
