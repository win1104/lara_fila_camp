<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->key('patient-form-card')
                    ->heading('病患資料')
                    ->icon('heroicon-m-bars-4')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->options([
                                'cat' => 'Cat',
                                'dog' => 'Dog',
                                'rabbit' => 'Rabbit',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required()
                            ->maxDate(now()),
                        Forms\Components\Select::make('owner_id')
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone number')
                                    ->tel()
                                    ->required(),
                            ])
                            ->required(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->footerActions([
                        Forms\Components\Actions\Action::make('save')
                            ->label('儲存')
                            ->submit('patient-form-card')
                            ->color('primary'),
                        // Forms\Components\Actions\Action::make('cancel')
                        //     ->label('取消')
                        //     ->url(PatientResource::getUrl('index'))
                        //     ->color('gray'),
                    ])
                    ,
                ])->columns(12)
                ->live();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('姓名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('類別'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('出生日期')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('主人')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                ->options([
                    'cat' => 'Cat',
                    'dog' => 'Dog',
                    'birds' => 'Birds',
                    'rabbit' => 'Rabbit',
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\CreateAction::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
