<?php

namespace App\Filament\Resources\LearningSessions\Pages;

use App\Filament\Resources\LearningSessions\LearningSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLearningSession extends CreateRecord
{
    protected static string $resource = LearningSessionResource::class;
}
