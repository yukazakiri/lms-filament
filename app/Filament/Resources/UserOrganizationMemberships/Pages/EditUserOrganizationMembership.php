<?php

namespace App\Filament\Resources\UserOrganizationMemberships\Pages;

use App\Filament\Resources\UserOrganizationMemberships\UserOrganizationMembershipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserOrganizationMembership extends EditRecord
{
    protected static string $resource = UserOrganizationMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
