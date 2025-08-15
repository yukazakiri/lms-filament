<?php

namespace App\Filament\Resources\AssessmentResponses;

use App\Filament\Resources\AssessmentResponses\Pages\CreateAssessmentResponse;
use App\Filament\Resources\AssessmentResponses\Pages\EditAssessmentResponse;
use App\Filament\Resources\AssessmentResponses\Pages\ListAssessmentResponses;
use App\Filament\Resources\AssessmentResponses\Schemas\AssessmentResponseForm;
use App\Filament\Resources\AssessmentResponses\Tables\AssessmentResponsesTable;
use App\Models\AssessmentResponse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentResponseResource extends Resource
{
    protected static ?string $model = AssessmentResponse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AssessmentResponseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentResponsesTable::configure($table);
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
            'index' => ListAssessmentResponses::route('/'),
            'create' => CreateAssessmentResponse::route('/create'),
            'edit' => EditAssessmentResponse::route('/{record}/edit'),
        ];
    }
}
