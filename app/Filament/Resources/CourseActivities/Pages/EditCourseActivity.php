<?php

namespace App\Filament\Resources\CourseActivities\Pages;

use App\Filament\Resources\CourseActivities\CourseActivityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseActivity extends EditRecord
{
    protected static string $resource = CourseActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
