<?php

namespace App\Filament\Resources\LearningNotes;

use App\Filament\Resources\LearningNotes\Pages\CreateLearningNote;
use App\Filament\Resources\LearningNotes\Pages\EditLearningNote;
use App\Filament\Resources\LearningNotes\Pages\ListLearningNotes;
use App\Filament\Resources\LearningNotes\Schemas\LearningNoteForm;
use App\Filament\Resources\LearningNotes\Tables\LearningNotesTable;
use App\Models\LearningNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LearningNoteResource extends Resource
{
    protected static ?string $model = LearningNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LearningNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLearningNotes::route('/'),
            'create' => CreateLearningNote::route('/create'),
            'edit' => EditLearningNote::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
