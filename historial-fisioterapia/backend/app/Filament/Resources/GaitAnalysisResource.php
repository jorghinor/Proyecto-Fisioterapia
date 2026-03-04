<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaitAnalysisResource\Pages;
use App\Filament\Resources\GaitAnalysisResource\RelationManagers;
use App\Models\GaitAnalysis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class GaitAnalysisResource extends Resource
{
    protected static ?string $model = GaitAnalysis::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Clinical Evaluations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'first_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('analysis_date')
                            ->required(),
                        Forms\Components\TextInput::make('video_url')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('observations')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.first_name')
                    ->label('Patient')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('patient', function (Builder $q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('analysis_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('video_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('analysis_date')
                ->form([
                    DatePicker::make('analysis_from'),
                    DatePicker::make('analysis_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['analysis_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('analysis_date', '>=', $date),
                        )
                        ->when(
                            $data['analysis_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('analysis_date', '<=', $date),
                        );
                })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGaitAnalyses::route('/'),
            'create' => Pages\CreateGaitAnalysis::route('/create'),
            'edit' => Pages\EditGaitAnalysis::route('/{record}/edit'),
        ];
    }
}
