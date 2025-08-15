<?php

namespace App\Filament\Resources\AppModelsCourses\Pages;

use App\Filament\Resources\AppModelsCourses\AppModelsCourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppModelsCourses extends ListRecords
{
    protected static string $resource = AppModelsCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
