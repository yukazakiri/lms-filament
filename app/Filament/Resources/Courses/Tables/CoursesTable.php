<?php

namespace App\Filament\Resources\Courses\Tables;

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

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('code')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('difficulty_level')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'published' => 'success',
                        'review' => 'warning',
                        'archived', 'suspended' => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_free')
                    ->boolean(),
                TextColumn::make('price')
                    ->money('usd')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('organization')
                    ->relationship('organization', 'name'),
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'In review',
                        'published' => 'Published',
                        'archived' => 'Archived',
                        'suspended' => 'Suspended',
                    ]),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
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
