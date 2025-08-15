<?php

namespace App\Filament\Resources\LearningBookmarks;

use App\Filament\Resources\LearningBookmarks\Pages\CreateLearningBookmark;
use App\Filament\Resources\LearningBookmarks\Pages\EditLearningBookmark;
use App\Filament\Resources\LearningBookmarks\Pages\ListLearningBookmarks;
use App\Filament\Resources\LearningBookmarks\Schemas\LearningBookmarkForm;
use App\Filament\Resources\LearningBookmarks\Tables\LearningBookmarksTable;
use App\Models\LearningBookmark;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LearningBookmarkResource extends Resource
{
    protected static ?string $model = LearningBookmark::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LearningBookmarkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningBookmarksTable::configure($table);
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
            'index' => ListLearningBookmarks::route('/'),
            'create' => CreateLearningBookmark::route('/create'),
            'edit' => EditLearningBookmark::route('/{record}/edit'),
        ];
    }
}
