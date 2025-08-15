<?php

namespace App\Filament\Resources\QuestionBanks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class QuestionBankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('subject'),
                TextInput::make('category'),
                TextInput::make('difficulty_level')
                    ->required()
                    ->default('mixed'),
                Textarea::make('tags')
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
            ]);
    }
}
