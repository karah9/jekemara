<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FermeResource\Pages;
use App\Filament\Resources\FermeResource\RelationManagers;
use App\Models\Cercle;
use App\Models\CommuneCercle;
use App\Models\CommuneDistrict;
use App\Models\Ferme;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Session;

class FermeResource extends Resource
{
    protected static ?string $model = Ferme::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulaire de creation de la ferme')
                    ->schema([
                        TextInput::make('nom')
                            ->label("Nom de la ferme")
                            ->unique()
                            ->required(),
                        TextInput::make('firstname')
                            ->label("Prénom du proprietaire")
                            ->unique()
                            ->required(),
                        TextInput::make('lastname')
                            ->label("Nom du proprietaire")
                            ->unique()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Telephone')
                            ->required(),
                        TextInput::make('email')
                            ->nullable(),
                        TextInput::make('pays')
                            ->default('Mali')
                            ->disabled()
                            ->required(),
                        Radio::make('zone')
                            ->label('District / Region')
                            ->required()
                            ->live()
                            ->options([
                                'district' => 'District',
                                'region' => 'Region',
                            ]),
                        Select::make('region')
                            ->label('Région')
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'district' || is_null($get('zone')))
                            ->options(Region::all()->pluck('nom', 'nom'))
                            ->live()
                            ->searchable(),
                        TextInput::make('district')
                            ->default('Bamako')
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'region' || is_null($get('zone')))
                            ->live(),
                        Select::make('cercle')
                            ->label('Cercle')
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'district' || is_null($get('zone')))
                            ->options(function (Forms\Get $get, Forms\Set $set){
                                if ($get('region')){
                                    $region = Region::whereNom($get('region'))->first();
                                    return Cercle::whereRegionId($region->id)->get()->pluck('nom', 'nom');
                                }else{
                                    return Cercle::all()->pluck('nom', 'nom');
                                }
                            })
                            ->searchable(),
                        Select::make('communecercle')
                            ->label('Commune du cercle')
                            ->options(function (Forms\Get $get, Forms\Set $set){
                                if ($get('cercle')){
                                    $cercle = Cercle::whereNom($get('cercle'))->first();
                                    return Communecercle::whereCercleId($cercle->id)->get()->pluck('nom', 'nom');
                                }else{
                                    return Communecercle::all()->pluck('nom', 'nom');
                                }
                            })
                            ->searchable()
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'district' || is_null($get('zone'))),
                        Select::make('communedistrict')
                            ->label("Commune du district")
                            ->options(Communedistrict::all()->pluck('nom', 'nom'))
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'region' || is_null($get('zone'))),
                        TextInput::make('village')
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'district' || is_null($get('zone'))),
                        TextInput::make('quartier')
                            ->hidden(fn(Forms\Get $get) => $get('zone') == 'region' || is_null($get('zone'))),
                        TextInput::make('longitude'),
                        TextInput::make('latitude'),
                        TextInput::make('cooperative'),
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('N°')->rowIndex(),
                TextColumn::make('nom')
                    ->label('Nom de la ferme'),
                TextColumn::make('infrastructures_count')
                    ->counts('infrastructures')
                    ->label('Nombres d\'infrastructures'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('localite')
                    ->placeholder(Session::get('location_type'))
                    ->label(Session::get('location_name')),
                TextColumn::make('commune'),
                TextColumn::make('ville'),
                TextColumn::make('village'),
                TextColumn::make('quartier'),
                TextColumn::make('user.fullname')
                    ->label('Nom de l\'utilisateur'),
            ])
            ->actions([
                Tables\Actions\Action::make('Rapport')
                    ->url(fn (Ferme $record): string => route('filament.admin.pages.rapport-technique', ['ferme_id' => $record]))
                    ->openUrlInNewTab(),
            ], position: ActionsPosition::BeforeColumns);

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
            'index' => Pages\ListFermes::route('/'),
            'create' => Pages\CreateFerme::route('/create'),
            'edit' => Pages\EditFerme::route('/{record}/edit'),
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
