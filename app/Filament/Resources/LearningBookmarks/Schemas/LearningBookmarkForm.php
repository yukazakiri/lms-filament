<?php

namespace App\Filament\Resources\LearningBookmarks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LearningBookmarkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                TextInput::make('module_id')
                    ->numeric(),
                TextInput::make('lesson_id')
                    ->numeric(),
                TextInput::make('activity_id')
                    ->numeric(),
                TextInput::make('content_type')
                    ->required(),
                TextInput::make('content_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Textarea::make('tags')
                    ->columnSpanFull(),
                Toggle::make('is_private')
                    ->required(),
            ]);
    }
}
