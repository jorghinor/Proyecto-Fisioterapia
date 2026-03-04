<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Patient;

class UltimosPacientesTable extends BaseWidget
{
    protected static ?string $heading = 'Últimos Pacientes Registrados';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Patient::query()->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->date(),
            ]);
    }
}
