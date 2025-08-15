<?php

namespace App\Filament\Resources\CourseActivities\Pages;

use App\Filament\Resources\CourseActivities\CourseActivityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseActivities extends ListRecords
{
    protected static string $resource = CourseActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
