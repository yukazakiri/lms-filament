<?php

namespace App\Filament\Resources\LearningNotes\Pages;

use App\Filament\Resources\LearningNotes\LearningNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLearningNote extends EditRecord
{
    protected static string $resource = LearningNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
