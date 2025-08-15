<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Organization')
                    ->columns(2)
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('type')
                            ->options([
                                'company' => 'Company',
                                'division' => 'Division',
                                'department' => 'Department',
                                'team' => 'Team',
                                'group' => 'Group',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('logo_url')
                            ->columnSpanFull(),
                        TextInput::make('website')
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                    ]),
                Section::make('Location')
                    ->columns(2)
                    ->schema([
                        TextInput::make('address_line_1'),
                        TextInput::make('address_line_2'),
                        TextInput::make('city'),
                        TextInput::make('state_province')
                            ->label('State / Province'),
                        TextInput::make('postal_code'),
                        TextInput::make('country'),
                    ]),
                Section::make('Locale & Settings')
                    ->columns(2)
                    ->schema([
                        TextInput::make('timezone')
                            ->required()
                            ->default('UTC'),
                        TextInput::make('locale')
                            ->required()
                            ->default('en'),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                            ])
                            ->required()
                            ->native(false),
                        Textarea::make('settings')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
