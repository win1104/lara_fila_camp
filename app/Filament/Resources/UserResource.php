<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\UserTag;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Member;
use Filament\Support\Colors\Color;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\UserStatsOverview;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $cluster = Member::class;
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';


    public static function getModelLabel(): string
    {
        return __('user.member_mana');
    }
    public static function getModelPluralLabel(): string
    {
        return __('user.member_mana');
    }
    public static function getNavigationLabel(): string
    {
        return __('user.member_mana');
    }

    protected static ?int $navigationSort = 1;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;





    /* 全文檢索 start */
    protected static int $globalSearchResultsLimit = 10;
    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name;
    }
    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Email' => $record->email,
            // 移除 Category 以避免 N+1 查詢問題
        ];
    }
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->select('users.id', 'users.name', 'users.email', 'user_details.mobile', 'user_details.firstname')
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->orderBy('users.name');
    }
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
            'userDetail.mobile',
            'userDetail.firstname',
        ];
    }
    /* 全文檢索 end */





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make(__('user.basic_info'))
                                    ->schema([
                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('user.slug'))
                                            ->disabled()
                                            ->helperText(__('user.slug_helper')),

                                        Forms\Components\TextInput::make('name')
                                            ->label(__('user.name'))
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('detail_note')
                                            ->label(__('user.note'))
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 2]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make(__('global.tag_settings'))
                                    ->schema([
                                        Forms\Components\FileUpload::make('avatar')
                                            ->label(__('user.avatar'))
                                            ->image()
                                            ->directory('avatars'),

                                        Forms\Components\Select::make('status')
                                            ->label(__('user.status'))
                                            ->options([
                                                'active' => __('user.status_active'),
                                                'inactive' => __('user.status_inactive'),
                                                'pending' => __('user.status_pending'),
                                            ])
                                            ->default('active'),

                                        Forms\Components\Select::make('userCategories')
                                            ->label(__('user.category'))
                                            ->relationship('userCategories', 'title')
                                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->title)
                                            ->searchable()
                                            ->preload()
                                            ->multiple(true)
                                            ->maxItems(1),

                                        Forms\Components\Select::make('userTags')
                                            ->label(__('user.member_tags'))
                                            ->multiple()
                                            ->relationship('userTags', 'title')
                                            ->getOptionLabelFromRecordUsing(fn (UserTag $record): string => $record->title)
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('title')
                                                    ->label(__('user.tag_name'))
                                                    ->required()
                                                    ->maxLength(255),

                                                Forms\Components\ColorPicker::make('color')
                                                    ->label(__('user.color'))
                                                    ->default('#3b82f6'),
                                            ])
                                            ->createOptionUsing(function (array $data): int {
                                                $tag = UserTag::create([
                                                    'name' => $data['name'],
                                                    'color' => $data['color'],
                                                    'creator_id' => auth()->id(),
                                                ]);
                                                return $tag->id;
                                            })
                                            ->searchable()
                                            ->preload(),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 1]),

                    ])
                    ->columns(3),

                Forms\Components\Section::make(__('user.detail_info'))
                    ->schema([
                        Forms\Components\TextInput::make('detail_type')
                            ->label(__('user.type')),

                        Forms\Components\TextInput::make('detail_sn')
                            ->label(__('user.sn')),

                        Forms\Components\TextInput::make('detail_pid')
                            ->label(__('user.pid')),

                        Forms\Components\TextInput::make('detail_firstname')
                            ->label(__('user.firstname')),

                        Forms\Components\TextInput::make('detail_lastname')
                            ->label(__('user.lastname')),

                        Forms\Components\Select::make('detail_gender')
                            ->label(__('user.gender'))
                            ->options([
                                'M' => __('user.gender_male'),
                                'F' => __('user.gender_female'),
                                'O' => __('user.gender_other'),
                            ]),

                        Forms\Components\DatePicker::make('detail_birthday')
                            ->label(__('user.birthday')),
                    ])
                    ->columns(3),

                Forms\Components\Section::make(__('user.contact_info'))
                    ->schema([
                        Forms\Components\TextInput::make('detail_phone')
                            ->label(__('user.phone'))
                            ->tel(),

                        Forms\Components\TextInput::make('detail_mobile')
                            ->label(__('user.mobile'))
                            ->tel(),

                        Forms\Components\TextInput::make('detail_fax')
                            ->label(__('user.fax')),

                        Forms\Components\TextInput::make('detail_fb_id')
                            ->label(__('user.fb_id')),

                        Forms\Components\TextInput::make('detail_line_id')
                            ->label(__('user.line_id')),

                        Forms\Components\TextInput::make('detail_website')
                            ->label(__('user.website'))
                            ->url(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('user.address_info'))
                    ->schema([
                        Forms\Components\TextInput::make('detail_country')
                            ->label(__('user.country')),

                        Forms\Components\TextInput::make('detail_city')
                            ->label(__('user.city')),

                        Forms\Components\TextInput::make('detail_district')
                            ->label(__('user.district')),

                        Forms\Components\TextInput::make('detail_zip')
                            ->label(__('user.zip')),

                        Forms\Components\Textarea::make('detail_address')
                            ->label(__('user.address'))
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('user.work_info'))
                    ->schema([
                        Forms\Components\TextInput::make('detail_company')
                            ->label(__('user.company')),

                        Forms\Components\TextInput::make('detail_company_no')
                            ->label(__('user.company_no')),

                        Forms\Components\TextInput::make('detail_position')
                            ->label(__('user.position')),

                        Forms\Components\TextInput::make('detail_job_title')
                            ->label(__('user.job_title')),

                        Forms\Components\TextInput::make('detail_education')
                            ->label(__('user.education')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('user.account_settings'))
                    ->schema([
                        Forms\Components\Toggle::make('detail_verify')
                            ->label(__('user.verify')),

                        Forms\Components\TextInput::make('detail_verify_code')
                            ->label(__('user.verify_code')),

                        Forms\Components\Toggle::make('detail_frozen')
                            ->label(__('user.frozen')),

                        Forms\Components\Toggle::make('detail_check')
                            ->label(__('user.check')),

                        Forms\Components\TextInput::make('detail_login_count')
                            ->label(__('user.login_count'))
                            ->numeric()
                            ->default(0),

                        Forms\Components\DateTimePicker::make('detail_expired')
                            ->label(__('user.expired')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('user.password_settings'))
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label(__('user.password'))
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('user.password_confirmation'))
                            ->password()
                            ->same('password')
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])
                    ->columns(1)
                    ->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label(__('user.avatar'))
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('user.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('userCategories.title')
                    ->label(__('user.category'))
                    ->color(fn (User $record): string =>
                        $record->userCategories()->first()?->title === '代理商' ? 'warning' : 'info'
                    )
                    ->formatStateUsing(fn (User $record): string =>
                        $record->userCategories()->first()?->title ?? '-'
                    )
                    ->badge(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label(__('user.slug'))
                    ->searchable()
                    ->copyable()
                    ->copyMessage(__('user.copy_message'))
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('userTags.title')
                    ->label(__('global.tag'))
                    ->badge()
                    ->state(function (User $record): array {
                        return $record->userTags()->get()->map(fn ($tag) => [
                            'label' => $tag->title,
                            'color' => $tag->color ?? '#808080',
                        ])->toArray();
                    })
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state['label'])
                    ->color(fn ($state) => Color::hex($state['color']))
                    ->separator(','),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('user.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => __('user.status_active'),
                        'inactive' => __('user.status_inactive'),
                        'pending' => __('user.status_pending'),
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('user.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('user.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('user.status'))
                    ->options([
                        'active' => __('user.status_active'),
                        'inactive' => __('user.status_inactive'),
                        'pending' => __('user.status_pending'),
                    ]),

                Tables\Filters\SelectFilter::make('userTags')
                    ->label(__('global.tag'))
                    ->relationship('userTags', 'name')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UserStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
