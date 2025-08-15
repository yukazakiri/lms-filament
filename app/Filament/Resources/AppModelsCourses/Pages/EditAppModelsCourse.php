<?php

namespace App\Filament\Resources\AppModelsCourses\Pages;

use App\Filament\Resources\AppModelsCourses\AppModelsCourseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAppModelsCourse extends EditRecord
{
    protected static string $resource = AppModelsCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
