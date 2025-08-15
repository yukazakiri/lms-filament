<?php

namespace App\Filament\Resources\LearningNotes\Pages;

use App\Filament\Resources\LearningNotes\LearningNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLearningNote extends CreateRecord
{
    protected static string $resource = LearningNoteResource::class;
}
