<?php

namespace App\Filament\Resources\CourseEnrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CourseEnrollmentForm
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
                TextInput::make('course_version_id')
                    ->numeric(),
                TextInput::make('enrollment_type')
                    ->required()
                    ->default('self'),
                TextInput::make('status')
                    ->required()
                    ->default('enrolled'),
                TextInput::make('progress_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('completion_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('grade')
                    ->numeric(),
                TextInput::make('grade_letter'),
                TextInput::make('points_earned')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points_possible')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('enrolled_at')
                    ->required(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('last_accessed_at'),
                DateTimePicker::make('completed_at'),
                DateTimePicker::make('expired_at'),
                DateTimePicker::make('withdrawn_at'),
                Textarea::make('withdrawal_reason')
                    ->columnSpanFull(),
                TextInput::make('enrolled_by')
                    ->numeric(),
                Textarea::make('completion_criteria_met')
                    ->columnSpanFull(),
                Textarea::make('custom_fields')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
