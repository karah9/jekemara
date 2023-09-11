<?php

namespace App\Filament\Resources;

use App\Filament\Pages\EditPdc;
use App\Filament\Resources\PdcResource\Pages;
use App\Filament\Resources\PdcResource\RelationManagers;
use App\Models\Aliment;
use App\Models\Cycle;
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
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PdcResource extends Resource
{
    protected static ?string $model = Pdc::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public $cycle;
    public $lastPdc;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulaire de creation d\'une pêche de contrôle')
                    ->schema([
                        Select::make('cycle_id')
                            ->relationship(
                                name: 'cycle',
                                titleAttribute: 'nom',
                                modifyQueryUsing: fn (Builder $query) => $query->whereNull('end_at'),
                            )
                            ->afterStateUpdated(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get, $state){
                                if (!empty($state)){
                                    $set('cycle', Cycle::find($state));
                                    $set('lastPdc', $get('cycle')->lastPdc);
                                }
                            })
                            ->label('Nom du cycle')
                            ->live()
                            ->required(),
                        Section::make('Les informations sur la pêche')
                            ->schema([
                                DatePicker::make('created_at')
                                    ->label('Date de la pêche de controle')
                                    ->rules([
                                        function (Forms\Get $get) {
                                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                                $minDate = date_add(clone $get('lastPdc')->created_at, date_interval_create_from_date_string('15 days'));
                                                if (new DateTime($value) < $minDate) {
                                                    $fail("La date doit être au moins 15 jours après la dernière PDC.");
                                                }
                                            };
                                        },
                                    ])
                                    ->helperText(function (Get $get){
                                        if ($get('cycle')){
                                            if($get('lastPdc')->type == 'charge'){
                                                return "La date de la mise en charge {$get('lastPdc')->created_at->format('d-m-Y')}";
                                            }
                                            else{
                                                return  "La date de la derniere PDC: {$get('lastPdc')->created_at->format('d-m-Y')}";
                                            }
                                        }
                                        return '';
                                    })
                                    ->required(),
                                TextInput::make('echant')
                                    ->required()
                                    ->numeric()
                                    ->label('Nombre de poissons echantillonés')
                                    ->live(),
                                TextInput::make('mortalite')
                                    ->live()
                                    ->default(0)
                                    ->numeric()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ($get('lastPdc')->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->label('Mortalité'),
                                TextInput::make('remplacement')
                                    ->live()
                                    ->default(0)
                                    ->numeric()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ($get('lastPdc')->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->label('Remplacement'),
                                TextInput::make('achat')
                                    ->numeric()
                                    ->hidden(fn(\Filament\Forms\Get $get) => empty($get('remplacement')))
                                    ->label('Cout de révient des poissons remplacés'),
                                TextInput::make('poids_moyen')
                                    ->label('Poids Moyen')
                                    ->live()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        $set('prise_poids',(int)$state - $get('lastPdc')->poids_moyen);
                                        if(!empty($get('ration'))){
                                            $biomasse = ($get('lastPdc')->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->helperText(function (Get $get) {
                                        if ($get('cycle')) {
                                            return "Poids moyen actuel {$get('lastPdc')->poids_moyen} g";
                                        }
                                    })
                                    ->rules([
                                        function (\Filament\Forms\Get $get, $state) {
                                            return function (string $attribute, $value, Closure $fail) use ($get, $state){
                                                if ($get('lastPdc')->poids_moyen > $state) {
                                                    $fail("Le {$attribute} $value doit etre superieur au précedent.");
                                                }
                                            };
                                        }
                                    ])
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('echant')))
                                    ->required(),
                                TextInput::make('prise_poids')
                                    ->label('Prise de poids')
                                    ->disabled(),
                                TextInput::make('ration')
                                    ->suffix('%')
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('echant')) || empty($get('poids_moyen')))
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($state)){
                                            $biomasse = ($get('lastPdc')->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->minValue('0')
                                    ->maxValue('10')
                                    ->live()
                                    ->helperText(function (Get $get) {
                                        if ($get('cycle')) {
                                            return "Ration actuel {$get('lastPdc')->alimentation->ration} %, la ration entre 1 à 10%";
                                        }
                                    })
                                    ->required(),
                                Section::make('alimentation')
                                    ->schema([
                                        Select::make('aliment_id')
                                            ->label('Aliment')
                                            ->options(Aliment::pluck('nom', 'id'))
                                            ->rules([
                                                function () {
                                                    return function (string $attribute, $value, Closure $fail) {
                                                        if ($value === 'foo') {
                                                            $fail("The {$attribute} is invalid.");
                                                        }
                                                    };
                                                },
                                            ])
                                            ->disabled(fn(\Filament\Forms\Get $get) => is_null($get('ration'))),
                                        TextInput::make('quantite')
                                            ->label('La quantité d\'aliment')
                                            ->suffix('Kg')
                                            ->disabled(),
                                        TextInput::make('prix')
                                            ->label('prix de l\'aliment')
                                            ->numeric()
                                            ->suffix('FCFA')
                                            ->disabled(fn(\Filament\Forms\Get $get) => is_null($get('ration'))),
                                    ])
                                    ->hidden(fn(\Filament\Forms\Get $get) =>$get('ration') == '0')
                                    ->columns(3)
                            ])
                            ->columns(3)
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
                Tables\Columns\TextColumn::make('echant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('achat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poids_moyen')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mortalite')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remplacement')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('survivant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('biomasse')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('poids_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prise_poids')
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
            'index' => Pages\ListPdcs::route('/'),
            'create' => Pages\CreatePdc::route('/create'),
            'edit' => EditPdc::route('/{record}/edit'),
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
