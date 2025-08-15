<?php

namespace App\Filament\Resources\CourseModules\Pages;

use App\Filament\Resources\CourseModules\CourseModuleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
