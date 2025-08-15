<?php

namespace App\Filament\Resources\CourseVersions\Pages;

use App\Filament\Resources\CourseVersions\CourseVersionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseVersions extends ListRecords
{
    protected static string $resource = CourseVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
