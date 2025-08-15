<?php

namespace App\Filament\Resources\UserAuthenticationMethods\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserAuthenticationMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('provider')
                    ->required(),
                TextInput::make('provider_id')
                    ->required(),
                TextInput::make('provider_email')
                    ->email(),
                Textarea::make('provider_data')
                    ->columnSpanFull(),
                Toggle::make('is_primary')
                    ->required(),
                DateTimePicker::make('verified_at'),
            ]);
    }
}
