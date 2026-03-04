<?php

namespace App\Filament\Resources\MuscleEvaluationResource\Pages;

use App\Filament\Resources\MuscleEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMuscleEvaluation extends EditRecord
{
    protected static string $resource = MuscleEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
