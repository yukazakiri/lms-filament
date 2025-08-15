<?php

namespace App\Filament\Resources\LearningBookmarks\Pages;

use App\Filament\Resources\LearningBookmarks\LearningBookmarkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLearningBookmarks extends ListRecords
{
    protected static string $resource = LearningBookmarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
