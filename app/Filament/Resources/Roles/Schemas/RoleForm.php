<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('organization_id')
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required()
                    ->default('custom'),
                TextInput::make('level')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('parent_role_id')
                    ->numeric(),
                Toggle::make('is_default')
                    ->required(),
                Toggle::make('is_system')
                    ->required(),
                Textarea::make('permissions')
                    ->columnSpanFull(),
                Textarea::make('settings')
                    ->columnSpanFull(),
            ]);
    }
}
