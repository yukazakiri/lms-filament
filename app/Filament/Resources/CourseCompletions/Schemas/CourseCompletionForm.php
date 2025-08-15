<?php

namespace App\Filament\Resources\CourseCompletions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseCompletionForm
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
                TextInput::make('completion_type')
                    ->required()
                    ->default('automatic'),
                DateTimePicker::make('completion_date')
                    ->required(),
                TextInput::make('final_grade')
                    ->numeric(),
                TextInput::make('final_grade_letter'),
                TextInput::make('total_points_earned')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_points_possible')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('completion_time')
                    ->numeric(),
                Textarea::make('criteria_met')
                    ->columnSpanFull(),
                Toggle::make('certificate_issued')
                    ->required(),
                TextInput::make('certificate_id'),
                TextInput::make('certificate_url'),
                DateTimePicker::make('certificate_issued_at'),
                TextInput::make('completed_by')
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
