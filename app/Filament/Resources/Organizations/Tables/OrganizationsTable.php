<?php

namespace App\Filament\Resources\Organizations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Parent')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('phone')
                    ->icon('heroicon-o-phone'),
                IconColumn::make('status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->getStateUsing(fn ($record) => $record->status === 'active')
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'company' => 'Company',
                        'division' => 'Division',
                        'department' => 'Department',
                        'team' => 'Team',
                        'group' => 'Group',
                    ]),
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
