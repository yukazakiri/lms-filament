<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\FileUpload;
// use Filament\Forms\Components\Grid;
// use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
// use Filament\Schemas\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditOrganizationProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Organization Profile';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Organization Name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Organization Slug')
                                    ->helperText('Used in URLs')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(1000)
                            ->rows(3),

                        Grid::make(2)
                            ->schema([
                                Select::make('type')
                                    ->label('Organization Type')
                                    ->options([
                                        'company' => 'Company',
                                        'division' => 'Division',
                                        'department' => 'Department',
                                        'team' => 'Team',
                                        'group' => 'Group',
                                    ])
                                    ->required(),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('website')
                                    ->label('Website')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(50),

                                Select::make('timezone')
                                    ->label('Timezone')
                                    ->options([
                                        'UTC' => 'UTC',
                                        'America/New_York' => 'Eastern Time',
                                        'America/Chicago' => 'Central Time',
                                        'America/Denver' => 'Mountain Time',
                                        'America/Los_Angeles' => 'Pacific Time',
                                        'Europe/London' => 'London',
                                        'Europe/Paris' => 'Paris',
                                        'Asia/Tokyo' => 'Tokyo',
                                        'Asia/Shanghai' => 'Shanghai',
                                        'Australia/Sydney' => 'Sydney',
                                    ])
                                    ->searchable()
                                    ->default('UTC'),
                            ]),
                    ]),

                Section::make('Address')
                    ->schema([
                        TextInput::make('address_line_1')
                            ->label('Address Line 1')
                            ->maxLength(255),

                        TextInput::make('address_line_2')
                            ->label('Address Line 2')
                            ->maxLength(255),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('city')
                                    ->label('City')
                                    ->maxLength(100),

                                TextInput::make('state_province')
                                    ->label('State/Province')
                                    ->maxLength(100),

                                TextInput::make('postal_code')
                                    ->label('Postal Code')
                                    ->maxLength(20),
                            ]),

                        TextInput::make('country')
                            ->label('Country')
                            ->maxLength(100),
                    ]),

                Section::make('Branding')
                    ->schema([
                        FileUpload::make('logo_url')
                            ->label('Organization Logo')
                            ->image()
                            ->directory('organization-logos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Upload a logo for your organization (max 2MB)'),
                    ]),
            ]);
    }
}
