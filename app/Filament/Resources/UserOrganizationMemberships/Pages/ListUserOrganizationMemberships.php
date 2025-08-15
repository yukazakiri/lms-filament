<?php

namespace App\Filament\Resources\UserOrganizationMemberships\Pages;

use App\Filament\Resources\UserOrganizationMemberships\UserOrganizationMembershipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserOrganizationMemberships extends ListRecords
{
    protected static string $resource = UserOrganizationMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
