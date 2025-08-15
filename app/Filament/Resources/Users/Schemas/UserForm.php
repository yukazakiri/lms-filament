<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('username'),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('middle_name'),
                TextInput::make('display_name'),
                TextInput::make('avatar_url'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('mobile'),
                DatePicker::make('date_of_birth'),
                TextInput::make('gender'),
                TextInput::make('timezone')
                    ->required()
                    ->default('UTC'),
                TextInput::make('locale')
                    ->required()
                    ->default('en'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('last_login_at'),
                DateTimePicker::make('last_activity_at'),
                DateTimePicker::make('password_changed_at'),
                Toggle::make('must_change_password')
                    ->required(),
                Toggle::make('two_factor_enabled')
                    ->required(),
                TextInput::make('two_factor_secret'),
            ]);
    }
}
