<?php

namespace App\Filament\Resources\LearningProgress\Pages;

use App\Filament\Resources\LearningProgress\LearningProgressResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLearningProgress extends EditRecord
{
    protected static string $resource = LearningProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
