<?php

namespace App\Filament\Resources\MobilityArcResource\Pages;

use App\Filament\Resources\MobilityArcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMobilityArcs extends ListRecords
{
    protected static string $resource = MobilityArcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
