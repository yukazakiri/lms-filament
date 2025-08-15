<?php

namespace App\Filament\Resources\AssessmentResponses\Pages;

use App\Filament\Resources\AssessmentResponses\AssessmentResponseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentResponse extends EditRecord
{
    protected static string $resource = AssessmentResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
