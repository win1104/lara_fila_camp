<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Forms;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\MarkdownEditor;

class CreateUser extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = UserResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('個人資料')
                ->description('Persional data')
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
                ]),
            Step::make('聯絡資料')
                ->description('Contact information')
                ->schema([
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
                ]),
            Step::make('公司資訊')
                ->description('About company')
                ->schema([
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
                    ]),
            Step::make('帳號設定')
                ->description('Account setting')
                ->schema([
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

                ]),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 分離 User 和 UserDetail 的資料，只返回 User 的資料
        $userData = [];
        $userDetailData = [];

        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'detail_')) {
                $userDetailKey = str_replace('detail_', '', $key);
                $userDetailData[$userDetailKey] = $value;
            } else {
                $userData[$key] = $value;
            }
        }

        // 將 UserDetail 資料暫存
        $this->userDetailData = $userDetailData;

        return $userData;
    }

    protected function afterCreate(): void
    {
        // 建立 UserDetail (如果有資料)
        if (isset($this->userDetailData) && !empty(array_filter($this->userDetailData))) {
            $this->userDetailData['user_id'] = $this->record->id;
            $this->record->userDetail()->create($this->userDetailData);
        }
    }

    protected $userDetailData = [];
}
