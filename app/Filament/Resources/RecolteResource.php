<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecolteResource\Pages;
use App\Filament\Resources\RecolteResource\RelationManagers;
use App\Models\Cycle;
use App\Models\Infrastructure;
use App\Models\Recolte;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecolteResource extends Resource
{
    protected static ?string $model = Recolte::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulaire de récolte')
                    ->schema([
                        Select::make('cycle_id')
                            ->relationship(
                                name: 'cycle',
                                titleAttribute: 'nom',
                            )
                            ->afterStateUpdated(function($state, Forms\Set $set) {
                                   $cycle = Cycle::find($state);
                                   $set('poids_total_restant',$cycle->poisson_produit - $cycle->alimentations->sum('poids_total'));

                                   $set('prix_revient', ceil($cycle->totalCharge / $cycle->lastPdc->biomasse));
                            })
                            ->label('Nom du cycle')
                            ->live()
                            ->required(),
                        Section::make('Les informations sur la récolte')
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        'vente' => 'Vente',
                                        'don'=> 'Don',
                                        'autoconsommation' => 'Autoconsommation'
                                    ]),
                                TextInput::make('poids_total')
                                    ->label('Poids total')
                                    ->helperText(fn(Get $get) => "Estimation du poids total restant : {$get('poids_total_restant')} Kg")
                                    ->numeric()
                                    ->suffix('Kg'),
                                TextInput::make('prixkg')
                                    ->label('Prix du Kilo')
                                    ->helperText(fn(Get $get) => "Prix de revient du kg de poisson : {$get('prix_revient')} FCFA")
                                    ->live(true)
                                    ->numeric()
                                    ->suffix('FCFA')
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                        $set('recette', $get('poids_total') * $get('prixkg'));
                                    })
                                    ->reactive(),
                                TextInput::make('recette')
                                    ->default(0)
                                    ->suffix('FCFA')
                                    ->disabled(),
                                DatePicker::make('created_at')
                                    ->label('Date'),
                            ])
                            //->disabled(fn(Forms\Get $get) => empty($get('infrastructure_id')))
                            ->columns(5)
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cycle_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poids_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prixkg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
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
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRecoltes::route('/'),
            'create' => Pages\CreateRecolte::route('/create'),
            'edit' => Pages\EditRecolte::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
