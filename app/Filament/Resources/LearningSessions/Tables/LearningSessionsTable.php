<?php

namespace App\Filament\Resources\LearningSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearningSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('course_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enrollment_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->searchable(),
                TextColumn::make('device_type')
                    ->searchable(),
                TextColumn::make('browser')
                    ->searchable(),
                TextColumn::make('platform')
                    ->searchable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('activities_completed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lessons_viewed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interactions_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('idle_time')
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
