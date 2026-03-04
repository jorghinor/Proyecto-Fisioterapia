<?php

namespace App\Filament\Resources\MuscleEvaluationResource\Pages;

use App\Filament\Resources\MuscleEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMuscleEvaluations extends ListRecords
{
    protected static string $resource = MuscleEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
