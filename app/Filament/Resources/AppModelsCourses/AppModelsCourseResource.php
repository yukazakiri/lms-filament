<?php

namespace App\Filament\Resources\AppModelsCourses;

use App\Filament\Resources\AppModelsCourses\Pages\CreateAppModelsCourse;
use App\Filament\Resources\AppModelsCourses\Pages\EditAppModelsCourse;
use App\Filament\Resources\AppModelsCourses\Pages\ListAppModelsCourses;
use App\Filament\Resources\AppModelsCourses\Schemas\AppModelsCourseForm;
use App\Filament\Resources\AppModelsCourses\Tables\AppModelsCoursesTable;
use App\Models\AppModelsCourse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppModelsCourseResource extends Resource
{
    protected static ?string $model = AppModelsCourse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AppModelsCourseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppModelsCoursesTable::configure($table);
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
            'index' => ListAppModelsCourses::route('/'),
            'create' => CreateAppModelsCourse::route('/create'),
            'edit' => EditAppModelsCourse::route('/{record}/edit'),
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
