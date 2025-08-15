<?php

namespace App\Filament\Resources\UserOrganizationMemberships\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserOrganizationMembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('organization_id')
                    ->required()
                    ->numeric(),
                TextInput::make('role')
                    ->required()
                    ->default('member'),
                TextInput::make('title'),
                Toggle::make('is_primary')
                    ->required(),
                DateTimePicker::make('joined_at')
                    ->required(),
                DateTimePicker::make('left_at'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
