<?php

namespace App\Filament\Resources\LearningProgress\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearningProgressTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('course_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('module_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lesson_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('activity_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('content_type')
                    ->searchable(),
                TextColumn::make('content_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('progress_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('time_spent')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('attempts_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_attempts')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_score')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('passed')
                    ->boolean(),
                TextColumn::make('first_accessed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_accessed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
