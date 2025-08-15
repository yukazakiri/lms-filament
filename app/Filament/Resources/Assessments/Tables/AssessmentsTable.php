<?php

namespace App\Filament\Resources\Assessments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AssessmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),
                TextColumn::make('course_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('activity_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('assessment_type')
                    ->searchable(),
                TextColumn::make('question_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('passing_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('time_limit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_attempts')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('attempt_delay')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('randomize_questions')
                    ->boolean(),
                IconColumn::make('randomize_answers')
                    ->boolean(),
                TextColumn::make('show_results')
                    ->searchable(),
                IconColumn::make('show_correct_answers')
                    ->boolean(),
                IconColumn::make('allow_review')
                    ->boolean(),
                IconColumn::make('require_lockdown_browser')
                    ->boolean(),
                IconColumn::make('require_webcam')
                    ->boolean(),
                IconColumn::make('auto_grade')
                    ->boolean(),
                IconColumn::make('is_practice')
                    ->boolean(),
                IconColumn::make('is_required')
                    ->boolean(),
                TextColumn::make('available_from')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('available_until')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('late_submission_allowed')
                    ->boolean(),
                TextColumn::make('late_penalty_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
