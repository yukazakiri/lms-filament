<?php

namespace App\Filament\Resources\Assessments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                TextInput::make('activity_id')
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('instructions')
                    ->columnSpanFull(),
                TextInput::make('assessment_type')
                    ->required(),
                TextInput::make('question_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('passing_score')
                    ->numeric(),
                TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('time_limit')
                    ->numeric(),
                TextInput::make('max_attempts')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('attempt_delay')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('randomize_questions')
                    ->required(),
                Toggle::make('randomize_answers')
                    ->required(),
                TextInput::make('show_results')
                    ->required()
                    ->default('after_submission'),
                Toggle::make('show_correct_answers')
                    ->required(),
                Toggle::make('allow_review')
                    ->required(),
                Toggle::make('require_lockdown_browser')
                    ->required(),
                Toggle::make('require_webcam')
                    ->required(),
                Toggle::make('auto_grade')
                    ->required(),
                Toggle::make('is_practice')
                    ->required(),
                Toggle::make('is_required')
                    ->required(),
                DateTimePicker::make('available_from'),
                DateTimePicker::make('available_until'),
                DateTimePicker::make('due_date'),
                Toggle::make('late_submission_allowed')
                    ->required(),
                TextInput::make('late_penalty_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('settings')
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
            ]);
    }
}
