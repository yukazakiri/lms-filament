<?php

namespace App\Filament\Resources\LearningProgress;

use App\Filament\Resources\LearningProgress\Pages\CreateLearningProgress;
use App\Filament\Resources\LearningProgress\Pages\EditLearningProgress;
use App\Filament\Resources\LearningProgress\Pages\ListLearningProgress;
use App\Filament\Resources\LearningProgress\Schemas\LearningProgressForm;
use App\Filament\Resources\LearningProgress\Tables\LearningProgressTable;
use App\Models\LearningProgress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LearningProgressResource extends Resource
{
    protected static ?string $model = LearningProgress::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LearningProgressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningProgressTable::configure($table);
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
            'index' => ListLearningProgress::route('/'),
            'create' => CreateLearningProgress::route('/create'),
            'edit' => EditLearningProgress::route('/{record}/edit'),
        ];
    }
}
