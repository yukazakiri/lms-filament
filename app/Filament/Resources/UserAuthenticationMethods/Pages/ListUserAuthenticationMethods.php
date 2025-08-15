<?php

namespace App\Filament\Resources\UserAuthenticationMethods\Pages;

use App\Filament\Resources\UserAuthenticationMethods\UserAuthenticationMethodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserAuthenticationMethods extends ListRecords
{
    protected static string $resource = UserAuthenticationMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
