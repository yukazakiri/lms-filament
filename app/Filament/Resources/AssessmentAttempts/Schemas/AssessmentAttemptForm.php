<?php

namespace App\Filament\Resources\AssessmentAttempts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentAttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('assessment_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('enrollment_id')
                    ->numeric(),
                TextInput::make('attempt_number')
                    ->required()
                    ->numeric()
                    ->default(1),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('submitted_at'),
                DateTimePicker::make('graded_at'),
                TextInput::make('duration')
                    ->numeric(),
                TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('passed')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('in_progress'),
                Textarea::make('answers')
                    ->columnSpanFull(),
                Textarea::make('feedback')
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
