<?php

namespace App\Filament\Resources\LearningSessions\Pages;

use App\Filament\Resources\LearningSessions\LearningSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLearningSession extends EditRecord
{
    protected static string $resource = LearningSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
