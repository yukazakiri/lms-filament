<?php

namespace App\Filament\Resources\LearningProgress\Pages;

use App\Filament\Resources\LearningProgress\LearningProgressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLearningProgress extends ListRecords
{
    protected static string $resource = LearningProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
