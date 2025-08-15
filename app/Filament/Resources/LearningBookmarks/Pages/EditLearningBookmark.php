<?php

namespace App\Filament\Resources\LearningBookmarks\Pages;

use App\Filament\Resources\LearningBookmarks\LearningBookmarkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLearningBookmark extends EditRecord
{
    protected static string $resource = LearningBookmarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
