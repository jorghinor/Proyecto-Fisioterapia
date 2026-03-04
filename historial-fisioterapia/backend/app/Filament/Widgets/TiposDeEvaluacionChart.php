<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\FunctionalAssessment;
use App\Models\GaitAnalysis;
use App\Models\MobilityArc;
use App\Models\MuscleEvaluation;
use App\Models\PostureEvaluation;

class TiposDeEvaluacionChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Tipos de Evaluación';

    protected function getData(): array
    {
        $data = [
            'datasets' => [
                [
                    'label' => 'Evaluaciones',
                    'data' => [
                        FunctionalAssessment::count(),
                        GaitAnalysis::count(),
                        MobilityArc::count(),
                        MuscleEvaluation::count(),
                        PostureEvaluation::count(),
                    ],
                    'backgroundColor' => ['#FF8A65', '#81C784', '#64B5F6', '#F06292', '#BA68C8', '#4DB6AC'],
                ],
            ],
            'labels' => ['Evaluación Funcional', 'Análisis de Marcha', 'Arcos de Movilidad', 'Evaluación Muscular', 'Evaluación Postural'],
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plotOptions' => [
                'pie' => [
                    'is3D' => true,
                ],
            ],
            'legend' => [
                'position' => 'bottom',
            ],
        ];
    }
}
