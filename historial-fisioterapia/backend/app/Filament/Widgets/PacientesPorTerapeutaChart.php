<?php

namespace App\Filament\Widgets;

use App\Models\Therapist;
use Filament\Widgets\ChartWidget;

class PacientesPorTerapeutaChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Pacientes por Terapeuta';

    protected function getData(): array
    {
        $therapists = Therapist::withCount('patients')->get();
        $colors = ['#FF8A65', '#81C784', '#64B5F6', '#F06292', '#BA68C8', '#4DB6AC'];

        $datasets = $therapists->map(function (Therapist $therapist, int $index) use ($colors) {
            return [
                'label' => $therapist->name,
                'data' => [$therapist->patients_count],
                'backgroundColor' => $colors[$index % count($colors)],
            ];
        })->all();

        return [
            'datasets' => $datasets,
            'labels' => [''],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plotOptions' => [
                'bar' => [
                    'is3D' => true,
                ],
            ],
            'legend' => [
                'position' => 'bottom',
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
