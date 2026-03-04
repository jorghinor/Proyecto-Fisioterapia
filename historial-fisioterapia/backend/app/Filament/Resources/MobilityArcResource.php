<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MobilityArcResource\Pages;
use App\Filament\Resources\MobilityArcResource\RelationManagers;
use App\Models\MobilityArc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;

class MobilityArcResource extends Resource
{
    protected static ?string $model = MobilityArc::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-pointing-out';

    protected static ?string $navigationGroup = 'Clinical Evaluations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Patient and Joint')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'first_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('joint')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Mobility Measurements')
                    ->schema([
                        Forms\Components\TextInput::make('flexion')
                            ->numeric()->suffix('°'),
                        Forms\Components\TextInput::make('extension')
                            ->numeric()->suffix('°'),
                        Forms\Components\TextInput::make('abduction')
                            ->numeric()->suffix('°'),
                        Forms\Components\TextInput::make('adduction')
                            ->numeric()->suffix('°'),
                        Forms\Components\TextInput::make('internal_rotation')
                            ->numeric()->suffix('°'),
                        Forms\Components\TextInput::make('external_rotation')
                            ->numeric()->suffix('°'),
                    ])->columns(3),
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
                Tables\Columns\TextColumn::make('joint')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flexion')->numeric()->sortable()->suffix('°'),
                Tables\Columns\TextColumn::make('extension')->numeric()->sortable()->suffix('°'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // You can add a SelectFilter for common joints if you have a predefined list
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
            'index' => Pages\ListMobilityArcs::route('/'),
            'create' => Pages\CreateMobilityArc::route('/create'),
            'edit' => Pages\EditMobilityArc::route('/{record}/edit'),
        ];
    }
}
