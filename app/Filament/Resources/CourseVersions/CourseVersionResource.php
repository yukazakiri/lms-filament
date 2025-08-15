<?php

namespace App\Filament\Resources\CourseVersions;

use App\Filament\Resources\CourseVersions\Pages\CreateCourseVersion;
use App\Filament\Resources\CourseVersions\Pages\EditCourseVersion;
use App\Filament\Resources\CourseVersions\Pages\ListCourseVersions;
use App\Filament\Resources\CourseVersions\Schemas\CourseVersionForm;
use App\Filament\Resources\CourseVersions\Tables\CourseVersionsTable;
use App\Models\CourseVersion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseVersionResource extends Resource
{
    protected static ?string $model = CourseVersion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CourseVersionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseVersionsTable::configure($table);
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
            'index' => ListCourseVersions::route('/'),
            'create' => CreateCourseVersion::route('/create'),
            'edit' => EditCourseVersion::route('/{record}/edit'),
        ];
    }
}
