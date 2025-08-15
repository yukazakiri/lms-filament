<?php

namespace App\Filament\Resources\CourseLessons\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseLessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lesson')
                    ->columns(2)
                    ->schema([
                        Select::make('module_id')
                            ->relationship('module', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('content')
                            ->columnSpanFull(),
                        Select::make('content_type')
                            ->options([
                                'text' => 'Text',
                                'video' => 'Video',
                                'audio' => 'Audio',
                                'document' => 'Document',
                                'presentation' => 'Presentation',
                                'interactive' => 'Interactive',
                                'external' => 'External',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('content_url')
                            ->columnSpanFull(),
                        Textarea::make('content_metadata')
                            ->columnSpanFull(),
                        TextInput::make('estimated_duration')
                            ->numeric()
                            ->suffix('min'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_required'),
                        Toggle::make('is_active'),
                        Toggle::make('is_preview'),
                        Textarea::make('unlock_conditions')
                            ->columnSpanFull(),
                        Textarea::make('completion_criteria')
                            ->columnSpanFull(),
                        Textarea::make('resources')
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
