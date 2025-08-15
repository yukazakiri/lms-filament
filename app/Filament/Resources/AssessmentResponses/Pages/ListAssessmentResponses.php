<?php

namespace App\Filament\Resources\AssessmentResponses\Pages;

use App\Filament\Resources\AssessmentResponses\AssessmentResponseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentResponses extends ListRecords
{
    protected static string $resource = AssessmentResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
