<?php

namespace App\Filament\Resources\FunctionalAssessmentResource\Pages;

use App\Filament\Resources\FunctionalAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFunctionalAssessments extends ListRecords
{
    protected static string $resource = FunctionalAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
