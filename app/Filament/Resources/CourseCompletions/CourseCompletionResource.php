<?php

namespace App\Filament\Resources\CourseCompletions;

use App\Filament\Resources\CourseCompletions\Pages\CreateCourseCompletion;
use App\Filament\Resources\CourseCompletions\Pages\EditCourseCompletion;
use App\Filament\Resources\CourseCompletions\Pages\ListCourseCompletions;
use App\Filament\Resources\CourseCompletions\Schemas\CourseCompletionForm;
use App\Filament\Resources\CourseCompletions\Tables\CourseCompletionsTable;
use App\Models\CourseCompletion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseCompletionResource extends Resource
{
    protected static ?string $model = CourseCompletion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CourseCompletionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseCompletionsTable::configure($table);
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
            'index' => ListCourseCompletions::route('/'),
            'create' => CreateCourseCompletion::route('/create'),
            'edit' => EditCourseCompletion::route('/{record}/edit'),
        ];
    }
}
