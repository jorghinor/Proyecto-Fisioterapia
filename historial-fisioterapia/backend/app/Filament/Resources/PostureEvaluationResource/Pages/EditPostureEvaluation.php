<?php

namespace App\Filament\Resources\PostureEvaluationResource\Pages;

use App\Filament\Resources\PostureEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostureEvaluation extends EditRecord
{
    protected static string $resource = PostureEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
