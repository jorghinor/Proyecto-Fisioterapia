<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\PacientesPorTerapeutaChart;
use App\Filament\Widgets\TiposDeEvaluacionChart;
use App\Filament\Widgets\UltimosPacientesTable;

class Reportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.reportes';

    protected static ?string $title = 'Módulo de Reportes';

    protected static ?string $navigationLabel = 'Reportes';

    protected function getHeaderWidgets(): array
    {
        return [
            PacientesPorTerapeutaChart::class,
            TiposDeEvaluacionChart::class,
            UltimosPacientesTable::class,
        ];
    }
}
