<?php

namespace App\Filament\Resources\UserOrganizationMemberships;

use App\Filament\Resources\UserOrganizationMemberships\Pages\CreateUserOrganizationMembership;
use App\Filament\Resources\UserOrganizationMemberships\Pages\EditUserOrganizationMembership;
use App\Filament\Resources\UserOrganizationMemberships\Pages\ListUserOrganizationMemberships;
use App\Filament\Resources\UserOrganizationMemberships\Schemas\UserOrganizationMembershipForm;
use App\Filament\Resources\UserOrganizationMemberships\Tables\UserOrganizationMembershipsTable;
use App\Models\UserOrganizationMembership;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserOrganizationMembershipResource extends Resource
{
    protected static ?string $model = UserOrganizationMembership::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // UserOrganizationMembership has a direct organization relationship
    protected static ?string $tenantOwnershipRelationshipName = 'organization';

    public static function form(Schema $schema): Schema
    {
        return UserOrganizationMembershipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserOrganizationMembershipsTable::configure($table);
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
            'index' => ListUserOrganizationMemberships::route('/'),
            'create' => CreateUserOrganizationMembership::route('/create'),
            'edit' => EditUserOrganizationMembership::route('/{record}/edit'),
        ];
    }
}
