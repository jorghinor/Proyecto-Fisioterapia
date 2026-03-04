<?php

namespace App\Filament\Resources\GaitAnalysisResource\Pages;

use App\Filament\Resources\GaitAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGaitAnalyses extends ListRecords
{
    protected static string $resource = GaitAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
