<?php

namespace App\Filament\Resources\CourseVersions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseVersionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('course_id')
                    ->required()
                    ->numeric(),
                TextInput::make('version_number')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('content_hash'),
                Toggle::make('is_current')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                Textarea::make('change_log')
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('published_by')
                    ->numeric(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
