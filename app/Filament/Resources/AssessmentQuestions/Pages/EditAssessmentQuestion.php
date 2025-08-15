<?php

namespace App\Filament\Resources\AssessmentQuestions\Pages;

use App\Filament\Resources\AssessmentQuestions\AssessmentQuestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentQuestion extends EditRecord
{
    protected static string $resource = AssessmentQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
