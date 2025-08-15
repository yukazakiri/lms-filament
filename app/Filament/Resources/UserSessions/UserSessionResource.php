<?php

namespace App\Filament\Resources\UserSessions;

use App\Filament\Resources\UserSessions\Pages\CreateUserSession;
use App\Filament\Resources\UserSessions\Pages\EditUserSession;
use App\Filament\Resources\UserSessions\Pages\ListUserSessions;
use App\Filament\Resources\UserSessions\Schemas\UserSessionForm;
use App\Filament\Resources\UserSessions\Tables\UserSessionsTable;
use App\Models\UserSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserSessionResource extends Resource
{
    protected static ?string $model = UserSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // UserSession is related to organizations through the user
    protected static ?string $tenantRelationshipName = 'user.organizations';

    public static function form(Schema $schema): Schema
    {
        return UserSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSessionsTable::configure($table);
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
            'index' => ListUserSessions::route('/'),
            'create' => CreateUserSession::route('/create'),
            'edit' => EditUserSession::route('/{record}/edit'),
        ];
    }
}
