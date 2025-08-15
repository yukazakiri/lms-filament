<?php

namespace App\Filament\Resources\UserAuthenticationMethods\Pages;

use App\Filament\Resources\UserAuthenticationMethods\UserAuthenticationMethodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserAuthenticationMethod extends EditRecord
{
    protected static string $resource = UserAuthenticationMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
