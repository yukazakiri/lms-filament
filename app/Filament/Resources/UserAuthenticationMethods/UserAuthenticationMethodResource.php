<?php

namespace App\Filament\Resources\UserAuthenticationMethods;

use App\Filament\Resources\UserAuthenticationMethods\Pages\CreateUserAuthenticationMethod;
use App\Filament\Resources\UserAuthenticationMethods\Pages\EditUserAuthenticationMethod;
use App\Filament\Resources\UserAuthenticationMethods\Pages\ListUserAuthenticationMethods;
use App\Filament\Resources\UserAuthenticationMethods\Schemas\UserAuthenticationMethodForm;
use App\Filament\Resources\UserAuthenticationMethods\Tables\UserAuthenticationMethodsTable;
use App\Models\UserAuthenticationMethod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserAuthenticationMethodResource extends Resource
{
    protected static ?string $model = UserAuthenticationMethod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // UserAuthenticationMethod is related to organizations through the user
    protected static ?string $tenantRelationshipName = 'user.organizations';

    public static function form(Schema $schema): Schema
    {
        return UserAuthenticationMethodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserAuthenticationMethodsTable::configure($table);
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
            'index' => ListUserAuthenticationMethods::route('/'),
            'create' => CreateUserAuthenticationMethod::route('/create'),
            'edit' => EditUserAuthenticationMethod::route('/{record}/edit'),
        ];
    }
}
