<?php

namespace App\Filament\Resources\CourseCompletions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseCompletionsTable
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
                TextColumn::make('completion_type')
                    ->searchable(),
                TextColumn::make('completion_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('final_grade_letter')
                    ->searchable(),
                TextColumn::make('total_points_earned')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_points_possible')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('completion_time')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('certificate_issued')
                    ->boolean(),
                TextColumn::make('certificate_id')
                    ->searchable(),
                TextColumn::make('certificate_url')
                    ->searchable(),
                TextColumn::make('certificate_issued_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_by')
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
