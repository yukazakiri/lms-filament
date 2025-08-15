<?php

namespace App\Filament\Resources\LearningSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LearningSessionForm
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
                TextInput::make('enrollment_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('ended_at'),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                TextInput::make('device_type'),
                TextInput::make('browser'),
                TextInput::make('platform'),
                TextInput::make('location'),
                TextInput::make('activities_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('lessons_viewed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('interactions_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('idle_time')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('session_data')
                    ->columnSpanFull(),
            ]);
    }
}
