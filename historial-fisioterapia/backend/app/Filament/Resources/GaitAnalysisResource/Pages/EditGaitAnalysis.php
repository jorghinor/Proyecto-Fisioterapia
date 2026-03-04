<?php

namespace App\Filament\Resources\GaitAnalysisResource\Pages;

use App\Filament\Resources\GaitAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGaitAnalysis extends EditRecord
{
    protected static string $resource = GaitAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
