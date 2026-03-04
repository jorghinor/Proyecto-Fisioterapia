<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostureEvaluationResource\Pages;
use App\Filament\Resources\PostureEvaluationResource\RelationManagers;
use App\Models\PostureEvaluation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Tabs;

class PostureEvaluationResource extends Resource
{
    protected static ?string $model = PostureEvaluation::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

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
                        Forms\Components\DatePicker::make('evaluation_date')
                            ->required(),
                    ])->columns(2),
                Tabs::make('Posture Views')->tabs([
                    Tabs\Tab::make('Anterior View')
                        ->schema([
                            Forms\Components\Textarea::make('anterior_view')
                                ->label('') // Hide label as it's in the tab
                                ->rows(10),
                        ]),
                    Tabs\Tab::make('Posterior View')
                        ->schema([
                            Forms\Components\Textarea::make('posterior_view')
                                ->label('')
                                ->rows(10),
                        ]),
                    Tabs\Tab::make('Lateral View')
                        ->schema([
                            Forms\Components\Textarea::make('lateral_view')
                                ->label('')
                                ->rows(10),
                        ]),
                ])->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('evaluation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('evaluation_date')
                ->form([
                    DatePicker::make('evaluation_from'),
                    DatePicker::make('evaluation_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['evaluation_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('evaluation_date', '>=', $date),
                        )
                        ->when(
                            $data['evaluation_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('evaluation_date', '<=', $date),
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
            'index' => Pages\ListPostureEvaluations::route('/'),
            'create' => Pages\CreatePostureEvaluation::route('/create'),
            'edit' => Pages\EditPostureEvaluation::route('/{record}/edit'),
        ];
    }
}
