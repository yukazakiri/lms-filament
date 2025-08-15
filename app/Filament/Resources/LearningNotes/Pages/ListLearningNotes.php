<?php

namespace App\Filament\Resources\LearningNotes\Pages;

use App\Filament\Resources\LearningNotes\LearningNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLearningNotes extends ListRecords
{
    protected static string $resource = LearningNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
