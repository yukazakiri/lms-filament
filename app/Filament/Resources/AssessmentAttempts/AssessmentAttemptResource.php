<?php

namespace App\Filament\Resources\AssessmentAttempts;

use App\Filament\Resources\AssessmentAttempts\Pages\CreateAssessmentAttempt;
use App\Filament\Resources\AssessmentAttempts\Pages\EditAssessmentAttempt;
use App\Filament\Resources\AssessmentAttempts\Pages\ListAssessmentAttempts;
use App\Filament\Resources\AssessmentAttempts\Schemas\AssessmentAttemptForm;
use App\Filament\Resources\AssessmentAttempts\Tables\AssessmentAttemptsTable;
use App\Models\AssessmentAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentAttemptResource extends Resource
{
    protected static ?string $model = AssessmentAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AssessmentAttemptForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentAttemptsTable::configure($table);
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
            'index' => ListAssessmentAttempts::route('/'),
            'create' => CreateAssessmentAttempt::route('/create'),
            'edit' => EditAssessmentAttempt::route('/{record}/edit'),
        ];
    }
}
