<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FunctionalAssessmentResource\Pages;
use App\Filament\Resources\FunctionalAssessmentResource\RelationManagers;
use App\Models\FunctionalAssessment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class FunctionalAssessmentResource extends Resource
{
    protected static ?string $model = FunctionalAssessment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Clinical Evaluations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'first_name') // Assuming you want to show the first name
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('assessment_date')
                            ->required(),
                        Forms\Components\TextInput::make('barthel_index')
                            ->numeric(),
                        Forms\Components\TextInput::make('lawton_brody_scale')
                            ->numeric(),
                        Forms\Components\Textarea::make('notes')
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
                Tables\Columns\TextColumn::make('assessment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barthel_index')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lawton_brody_scale')
                    ->numeric()
                    ->sortable(),
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
                Filter::make('assessment_date')
                ->form([
                    DatePicker::make('assessment_from'),
                    DatePicker::make('assessment_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['assessment_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('assessment_date', '>=', $date),
                        )
                        ->when(
                            $data['assessment_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('assessment_date', '<=', $date),
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
            'index' => Pages\ListFunctionalAssessments::route('/'),
            'create' => Pages\CreateFunctionalAssessment::route('/create'),
            'edit' => Pages\EditFunctionalAssessment::route('/{record}/edit'),
        ];
    }
}
