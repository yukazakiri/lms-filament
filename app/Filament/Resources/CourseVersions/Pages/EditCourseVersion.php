<?php

namespace App\Filament\Resources\CourseVersions\Pages;

use App\Filament\Resources\CourseVersions\CourseVersionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseVersion extends EditRecord
{
    protected static string $resource = CourseVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
