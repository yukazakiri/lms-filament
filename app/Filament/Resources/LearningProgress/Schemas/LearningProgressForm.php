<?php

namespace App\Filament\Resources\LearningProgress\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LearningProgressForm
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
                TextInput::make('status')
                    ->required()
                    ->default('not_started'),
                TextInput::make('progress_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('time_spent')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('attempts_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_attempts')
                    ->numeric(),
                TextInput::make('score')
                    ->numeric(),
                TextInput::make('max_score')
                    ->numeric(),
                Toggle::make('passed'),
                DateTimePicker::make('first_accessed_at'),
                DateTimePicker::make('last_accessed_at'),
                DateTimePicker::make('completed_at'),
                Textarea::make('data')
                    ->columnSpanFull(),
            ]);
    }
}
