<?php

namespace App\Filament\Resources\UserRoles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('role_id')
                    ->required()
                    ->numeric(),
                TextInput::make('organization_id')
                    ->numeric(),
                TextInput::make('context_type'),
                TextInput::make('context_id')
                    ->numeric(),
                TextInput::make('assigned_by')
                    ->numeric(),
                DateTimePicker::make('assigned_at')
                    ->required(),
                DateTimePicker::make('expires_at'),
                DateTimePicker::make('revoked_at'),
                TextInput::make('revoked_by')
                    ->numeric(),
                Textarea::make('revoke_reason')
                    ->columnSpanFull(),
            ]);
    }
}
