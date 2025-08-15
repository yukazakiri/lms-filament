<?php

namespace App\Filament\Resources\CourseModules\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Module')
                    ->columns(2)
                    ->schema([
                        Select::make('course_id')
                            ->relationship('course', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('course_version_id')
                            ->relationship('version', 'version_number')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('parent_module_id')
                            ->label('Parent module')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('objectives')
                            ->columnSpanFull(),
                        TextInput::make('estimated_duration')
                            ->numeric()
                            ->suffix('min'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_required'),
                        Toggle::make('is_active'),
                        Textarea::make('unlock_conditions')
                            ->columnSpanFull(),
                        Textarea::make('completion_criteria')
                            ->columnSpanFull(),
                        Textarea::make('metadata')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
