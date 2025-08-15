<?php

namespace App\Filament\Resources\AssessmentResponses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssessmentResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('attempt_id')
                    ->required()
                    ->numeric(),
                TextInput::make('question_id')
                    ->required()
                    ->numeric(),
                Textarea::make('answer_data')
                    ->columnSpanFull(),
                TextInput::make('score')
                    ->numeric(),
                Toggle::make('is_correct'),
                Textarea::make('feedback')
                    ->columnSpanFull(),
            ]);
    }
}
