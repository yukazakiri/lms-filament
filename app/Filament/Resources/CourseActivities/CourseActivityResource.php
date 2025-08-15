<?php

namespace App\Filament\Resources\CourseActivities;

use App\Filament\Resources\CourseActivities\Pages\CreateCourseActivity;
use App\Filament\Resources\CourseActivities\Pages\EditCourseActivity;
use App\Filament\Resources\CourseActivities\Pages\ListCourseActivities;
use App\Filament\Resources\CourseActivities\Schemas\CourseActivityForm;
use App\Filament\Resources\CourseActivities\Tables\CourseActivitiesTable;
use App\Models\CourseActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseActivityResource extends Resource
{
    protected static ?string $model = CourseActivity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CourseActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseActivitiesTable::configure($table);
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
            'index' => ListCourseActivities::route('/'),
            'create' => CreateCourseActivity::route('/create'),
            'edit' => EditCourseActivity::route('/{record}/edit'),
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
