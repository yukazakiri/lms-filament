<?php

namespace App\Filament\Resources\CourseActivities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity')
                    ->columns(2)
                    ->schema([
                        Select::make('course_id')
                            ->relationship('course', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('module_id')
                            ->relationship('module', 'title')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('lesson_id')
                            ->relationship('lesson', 'title')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('instructions')
                            ->columnSpanFull(),
                        Select::make('activity_type')
                            ->options([
                                'quiz' => 'Quiz',
                                'assignment' => 'Assignment',
                                'discussion' => 'Discussion',
                                'survey' => 'Survey',
                                'scorm' => 'SCORM',
                                'xapi' => 'xAPI',
                                'external' => 'External',
                            ])
                            ->required()
                            ->native(false),
                        Textarea::make('activity_data')
                            ->columnSpanFull(),
                        TextInput::make('max_attempts')
                            ->numeric()
                            ->default(1),
                        TextInput::make('time_limit')
                            ->numeric(),
                        TextInput::make('passing_score')
                            ->numeric(),
                        TextInput::make('weight')
                            ->numeric()
                            ->default(1),
                        Toggle::make('is_graded'),
                        Toggle::make('is_required'),
                        Toggle::make('is_active'),
                        Textarea::make('unlock_conditions')
                            ->columnSpanFull(),
                        Textarea::make('completion_criteria')
                            ->columnSpanFull(),
                        Textarea::make('feedback_settings')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        DateTimePicker::make('due_date'),
                        DateTimePicker::make('available_from'),
                        DateTimePicker::make('available_until'),
                    ]),
            ]);
    }
}
