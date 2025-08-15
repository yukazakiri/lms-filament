<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                    ->columns(2)
                    ->schema([
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('code')
                            ->unique(ignoreRecord: true),
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('subtitle')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('objectives')
                            ->columnSpanFull(),
                        Textarea::make('prerequisites')
                            ->columnSpanFull(),
                        Textarea::make('target_audience')
                            ->columnSpanFull(),
                        Select::make('difficulty_level')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                                'expert' => 'Expert',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('estimated_duration')
                            ->numeric()
                            ->suffix('min'),
                        TextInput::make('language')
                            ->default('en'),
                        TextInput::make('thumbnail_url'),
                        TextInput::make('trailer_url'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'review' => 'In review',
                                'published' => 'Published',
                                'archived' => 'Archived',
                                'suspended' => 'Suspended',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('type')
                            ->options([
                                'self_paced' => 'Self-paced',
                                'instructor_led' => 'Instructor-led',
                                'blended' => 'Blended',
                                'webinar' => 'Webinar',
                                'workshop' => 'Workshop',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('delivery_method')
                            ->options([
                                'online' => 'Online',
                                'classroom' => 'Classroom',
                                'hybrid' => 'Hybrid',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('max_enrollments')
                            ->numeric(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('currency')
                            ->default('USD'),
                        Toggle::make('is_free')
                            ->inline(false),
                        Toggle::make('is_featured')
                            ->inline(false),
                        Toggle::make('is_public')
                            ->inline(false),
                        Toggle::make('requires_approval')
                            ->inline(false),
                        TextInput::make('certificate_template_id')
                            ->numeric(),
                        Textarea::make('completion_criteria')
                            ->columnSpanFull(),
                        Textarea::make('tags')
                            ->columnSpanFull(),
                        Textarea::make('metadata')
                            ->columnSpanFull(),
                        TextInput::make('seo_title'),
                        Textarea::make('seo_description')
                            ->columnSpanFull(),
                        Textarea::make('seo_keywords')
                            ->columnSpanFull(),
                        DateTimePicker::make('published_at'),
                        DateTimePicker::make('archived_at'),
                    ]),
            ]);
    }
}
