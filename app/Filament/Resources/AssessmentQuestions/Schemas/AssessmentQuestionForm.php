<?php

namespace App\Filament\Resources\AssessmentQuestions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentQuestionForm
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
                TextInput::make('question_type')
                    ->required(),
                Textarea::make('question_text')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('question_html')
                    ->columnSpanFull(),
                TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_required')
                    ->required(),
                TextInput::make('time_limit')
                    ->numeric(),
                Textarea::make('question_data')
                    ->columnSpanFull(),
                Textarea::make('media_files')
                    ->columnSpanFull(),
            ]);
    }
}
