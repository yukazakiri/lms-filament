<?php

namespace App\Filament\Resources\UserOrganizationMemberships\Pages;

use App\Filament\Resources\UserOrganizationMemberships\UserOrganizationMembershipResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserOrganizationMembership extends CreateRecord
{
    protected static string $resource = UserOrganizationMembershipResource::class;
}
