<?php

namespace App\Filament\Resources\UserSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                TextInput::make('device_type'),
                TextInput::make('browser'),
                TextInput::make('platform'),
                TextInput::make('location'),
                Toggle::make('is_mobile')
                    ->required(),
                DateTimePicker::make('last_activity')
                    ->required(),
            ]);
    }
}
