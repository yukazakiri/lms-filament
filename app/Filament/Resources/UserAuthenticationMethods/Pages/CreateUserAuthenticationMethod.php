<?php

namespace App\Filament\Resources\UserAuthenticationMethods\Pages;

use App\Filament\Resources\UserAuthenticationMethods\UserAuthenticationMethodResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAuthenticationMethod extends CreateRecord
{
    protected static string $resource = UserAuthenticationMethodResource::class;
}
