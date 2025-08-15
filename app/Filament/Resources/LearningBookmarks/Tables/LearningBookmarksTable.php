<?php

namespace App\Filament\Resources\LearningBookmarks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearningBookmarksTable
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
                TextColumn::make('title')
                    ->searchable(),
                IconColumn::make('is_private')
                    ->boolean(),
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
