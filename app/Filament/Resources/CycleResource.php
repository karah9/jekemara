<?php

namespace App\Filament\Resources;

use App\Filament\Pages\EditCycle;
use App\Filament\Pages\EditPdc;
use App\Filament\Resources\CycleResource\Pages;
use App\Filament\Resources\CycleResource\RelationManagers;
use App\Models\Aliment;
use App\Models\Alimentation;
use App\Models\Cycle;
use App\Models\Espece;
use App\Models\Infrastructure;
use App\Models\Pdc;
use Closure;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CycleResource extends Resource
{
    protected static ?string $model = Cycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Mise en charge')
                    ->description("Formulaire d'ajout d'un nouveau cycle")
                    ->schema([
                        Select::make('infrastructure_id')
                            ->options(Infrastructure::whereCycleFin()->pluck('nom', 'id'))
                            ->label('Nom de l\'infrastructure')
                            ->live()
                            ->autofocus()
                            ->helperText("Veuillez choisir l'infrastructure")
                            ->required(),
                        Section::make('Les informations sur le cycle')
                            ->schema([
                                DatePicker::make('created_at')
                                    ->label('Date de la mise en charge')
                                    ->rules([
                                        function (Forms\Get $get) {
                                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                                $lastCycle = CYcle::where('infrastructure_id', $get('infrastructure_id'))->latest()->first();
                                                if (new DateTime($value) < $lastCycle->end_at) {
                                                    $fail("La date doit être au superieure à la derniere mise en charge.");
                                                }
                                            };
                                        },
                                    ])
                                    ->required(),
                                Select::make('espece_id')
                                    ->relationship(name: 'espece', titleAttribute: 'nom')
                                    ->live()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nom')
                                    ]),
                                TextInput::make('nombre')
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('espece_id')))
                                    ->afterStateUpdated(function(\Filament\Forms\Get $get, \Filament\Forms\Set $set, $state){
                                        if(!empty($get('ration'))){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->numeric()
                                    ->live()
                                    ->required(),
                                TextInput::make('mortalite')
                                    ->live()
                                    ->numeric()
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('nombre')))
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->default(0)
                                    ->label('Mortalité'),
                                TextInput::make('remplacement')
                                    ->live()
                                    ->numeric()
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('nombre')))
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse *(float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->label('Remplacement')
                                    ->default(0),
                                TextInput::make('achat')
                                    ->label('Cout de révient')
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('nombre')))
                                    ->required(),
                                TextInput::make('poids_moyen')
                                    ->label('Poids Moyen')
                                    ->live()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('nombre')))
                                    ->required(),

                                TextInput::make('ration')
                                    ->suffix('%')
                                    ->helperText('La ration entre 1 à 10%')
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('nombre')) || empty($get('poids_moyen')))
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($state)){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->minValue('0')
                                    ->maxValue('10')
                                    ->live()
                                    ->required(),
                                Select::make('aliment_id')
                                    ->options(Aliment::pluck('nom', 'id'))
                                    ->label('Aliment')
                                    ->required()
                                    ->disabled(fn(\Filament\Forms\Get $get) => is_null($get('ration'))),
                                TextInput::make('quantite')
                                    ->label('La quantité d\'aliment')
                                    ->required()
                                    ->suffix('Kg')
                                    ->disabled(),
                                TextInput::make('prix')
                                    ->label('prix de l\'aliment')
                                    ->numeric()
                                    ->suffix('FCFA')
                                    ->required()
                                    ->disabled(fn(\Filament\Forms\Get $get) => is_null($get('ration'))),
                            ])
                            ->columns(3)
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('N°')->rowIndex(),
                TextColumn::make('espece.nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('infrastructure.nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('infrastructure.type.nom')
                    ->getStateUsing(fn(Model $record) => $record->infrastructure->typeInfrastructure->nom)
                    ->label('type d\'infrastructure'),
                Tables\Columns\TextColumn::make('end_at')
                    ->dateTime()
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
                Tables\Actions\Action::make('Rapport')
                    ->url(fn (Cycle $record): string => route('filament.admin.pages.rapport-technique-cycle', ['cycle_id' => $record]))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('Bilan')
                    ->url(fn (Cycle $record): string => route('filament.admin.pages.bilan-financier-cycle', ['cycle_id' => $record]))
                    ->openUrlInNewTab(),
            ], position: ActionsPosition::BeforeColumns);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TraitementsRelationManager::class,
            RelationManagers\DepensesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCycles::route('/'),
            'create' => Pages\CreateCycle::route('/create'),
            'edit' => EditCycle::route('/{record}/edit'),
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
