<?php

namespace App\Filament\Resources\CourseCategories\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category')
                    ->columns(2)
                    ->schema([
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('parent_id')
                            ->label('Parent category')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        TextInput::make('icon'),
                        TextInput::make('color'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->default(true),
                        Textarea::make('metadata')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
