<?php

namespace App\Filament\Resources\LearningSessions;

use App\Filament\Resources\LearningSessions\Pages\CreateLearningSession;
use App\Filament\Resources\LearningSessions\Pages\EditLearningSession;
use App\Filament\Resources\LearningSessions\Pages\ListLearningSessions;
use App\Filament\Resources\LearningSessions\Schemas\LearningSessionForm;
use App\Filament\Resources\LearningSessions\Tables\LearningSessionsTable;
use App\Models\LearningSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LearningSessionResource extends Resource
{
    protected static ?string $model = LearningSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LearningSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningSessionsTable::configure($table);
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
            'index' => ListLearningSessions::route('/'),
            'create' => CreateLearningSession::route('/create'),
            'edit' => EditLearningSession::route('/{record}/edit'),
        ];
    }
}
