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
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    // 指定這個 Resource 屬於 Blog Cluster
    protected static ?string $cluster = Member::class;


    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // 在 Cluster 內的排序
    protected static ?int $navigationSort = 1;
    // public static function getModelLabel(): string
    // {
    //     return __('user.member');
    // }
    // public static function getModelPluralLabel(): string
    // {
    //     return __('user.member');
    // }
    public static function getNavigationLabel(): string
    {
        return __('user.member_mana');
    }
    // protected static ?string $navigationGroup = 'User';





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
                Forms\Components\Section::make('基本資料')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('姓名')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('public_slug')
                            ->label('公開編號')
                            ->disabled()
                            ->helperText('系統自動生成的8位數編號'),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('頭像')
                            ->image()
                            ->directory('avatars'),

                        Forms\Components\Select::make('status')
                            ->label('狀態')
                            ->options([
                                'active' => '啟用',
                                'inactive' => '停用',
                                'pending' => '待審核',
                            ])
                            ->default('active'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('詳細資料')
                    ->schema([
                        Forms\Components\TextInput::make('detail_type')
                            ->label('會員類型'),

                        Forms\Components\TextInput::make('detail_sn')
                            ->label('會員序號'),

                        Forms\Components\TextInput::make('detail_pid')
                            ->label('身份證號碼'),

                        Forms\Components\TextInput::make('detail_firstname')
                            ->label('名'),

                        Forms\Components\TextInput::make('detail_lastname')
                            ->label('姓'),

                        Forms\Components\Select::make('detail_gender')
                            ->label('性別')
                            ->options([
                                'M' => '男',
                                'F' => '女',
                                'O' => '其他',
                            ]),

                        Forms\Components\DatePicker::make('detail_birthday')
                            ->label('生日'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('聯絡資訊')
                    ->schema([
                        Forms\Components\TextInput::make('detail_phone')
                            ->label('電話')
                            ->tel(),

                        Forms\Components\TextInput::make('detail_mobile')
                            ->label('手機')
                            ->tel(),

                        Forms\Components\TextInput::make('detail_fax')
                            ->label('傳真'),

                        Forms\Components\TextInput::make('detail_fb_id')
                            ->label('Facebook ID'),

                        Forms\Components\TextInput::make('detail_line_id')
                            ->label('Line ID'),

                        Forms\Components\TextInput::make('detail_website')
                            ->label('網站')
                            ->url(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('地址資訊')
                    ->schema([
                        Forms\Components\TextInput::make('detail_country')
                            ->label('國家'),

                        Forms\Components\TextInput::make('detail_city')
                            ->label('城市'),

                        Forms\Components\TextInput::make('detail_district')
                            ->label('區域'),

                        Forms\Components\TextInput::make('detail_zip')
                            ->label('郵遞區號'),

                        Forms\Components\Textarea::make('detail_address')
                            ->label('地址')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('工作資訊')
                    ->schema([
                        Forms\Components\TextInput::make('detail_company')
                            ->label('公司名稱'),

                        Forms\Components\TextInput::make('detail_company_no')
                            ->label('公司統編'),

                        Forms\Components\TextInput::make('detail_position')
                            ->label('職位'),

                        Forms\Components\TextInput::make('detail_job_title')
                            ->label('職稱'),

                        Forms\Components\TextInput::make('detail_education')
                            ->label('學歷'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('帳戶設定')
                    ->schema([
                        Forms\Components\Toggle::make('detail_verify')
                            ->label('已驗證'),

                        Forms\Components\TextInput::make('detail_verify_code')
                            ->label('驗證碼'),

                        Forms\Components\Toggle::make('detail_frozen')
                            ->label('凍結'),

                        Forms\Components\Toggle::make('detail_check')
                            ->label('已檢查'),

                        Forms\Components\TextInput::make('detail_login_count')
                            ->label('登入次數')
                            ->numeric()
                            ->default(0),

                        Forms\Components\DateTimePicker::make('detail_expired')
                            ->label('到期時間'),

                        Forms\Components\Textarea::make('detail_note')
                            ->label('備註')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('標籤設定')
                    ->schema([
                        Forms\Components\Select::make('userTags')
                            ->label('會員標籤')
                            ->multiple()
                            ->relationship('userTags', 'name')
                            ->getOptionLabelFromRecordUsing(fn (UserTag $record): string => $record->name)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('標籤名稱')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\ColorPicker::make('color')
                                    ->label('顏色')
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

                Forms\Components\Section::make('密碼設定')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('密碼')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('確認密碼')
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
                    ->label('頭像')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('姓名')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('public_slug')
                    ->label('公開編號')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('已複製公開編號')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('userTags.name')
                    ->label('標籤')
                    ->badge()
                    ->state(function (User $record): array {
                        return $record->userTags()->get()->map(fn ($tag) => [
                            'label' => $tag->name,
                            'color' => $tag->color ?? '#808080',
                        ])->toArray();
                    })
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state['label'])
                    ->color(fn ($state) => Color::hex($state['color']))
                    ->separator(','),

                Tables\Columns\TextColumn::make('status')
                    ->label('狀態')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => '啟用',
                        'inactive' => '停用',
                        'pending' => '待審核',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('狀態')
                    ->options([
                        'active' => '啟用',
                        'inactive' => '停用',
                        'pending' => '待審核',
                    ]),

                Tables\Filters\SelectFilter::make('userTags')
                    ->label('標籤')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
