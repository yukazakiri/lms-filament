<?php

namespace App\Filament\Resources\CourseEnrollments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseEnrollmentsTable
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
                TextColumn::make('course_version_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enrollment_type')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('progress_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('completion_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grade')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grade_letter')
                    ->searchable(),
                TextColumn::make('points_earned')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points_possible')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enrolled_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_accessed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expired_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('withdrawn_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('enrolled_by')
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
