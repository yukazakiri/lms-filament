<?php

namespace App\Filament\Resources\App\Models\Courses\Pages;

use App\Filament\Resources\App\Models\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}
