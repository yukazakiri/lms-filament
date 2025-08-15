<?php

namespace App\Filament\Resources\LearningNotes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LearningNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
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
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content_html')
                    ->columnSpanFull(),
                Toggle::make('is_private')
                    ->required(),
                Toggle::make('is_shared')
                    ->required(),
                Textarea::make('tags')
                    ->columnSpanFull(),
                Textarea::make('attachments')
                    ->columnSpanFull(),
            ]);
    }
}
