<?php

namespace App\Filament\Resources\LearningSessions\Pages;

use App\Filament\Resources\LearningSessions\LearningSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLearningSessions extends ListRecords
{
    protected static string $resource = LearningSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
