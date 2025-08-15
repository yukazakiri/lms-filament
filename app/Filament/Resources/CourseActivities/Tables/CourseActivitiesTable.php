<?php

namespace App\Filament\Resources\CourseActivities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CourseActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.title')
                    ->label('Course')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('module.title')
                    ->label('Module')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('lesson.title')
                    ->label('Lesson')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('activity_type')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'quiz' => 'primary',
                        'assignment' => 'warning',
                        'discussion' => 'info',
                        'survey' => 'gray',
                        'scorm', 'xapi' => 'success',
                        'external' => 'pink',
                        default => 'gray',
                    }),
                IconColumn::make('is_graded')
                    ->boolean(),
                IconColumn::make('is_required')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('max_attempts')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('passing_score')
                    ->numeric()
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('course')
                    ->relationship('course', 'title'),
                SelectFilter::make('activity_type')
                    ->options([
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                        'discussion' => 'Discussion',
                        'survey' => 'Survey',
                        'scorm' => 'SCORM',
                        'xapi' => 'xAPI',
                        'external' => 'External',
                    ]),
                TernaryFilter::make('is_graded')
                    ->label('Graded'),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
