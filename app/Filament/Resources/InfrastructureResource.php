<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfrastructureResource\Pages;
use App\Filament\Resources\InfrastructureResource\RelationManagers;
use App\Models\Ferme;
use App\Models\Infrastructure;
use App\Models\TypeInfrastructure;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Livewire;

class InfrastructureResource extends Resource
{
    protected static ?string $model = Infrastructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Formulaire de création d'infrastructure")
                    ->schema([
                        Select::make('ferme_id')
                            ->label('Nom de la ferme')
                            ->reactive()
                            ->required()
                            ->options(Ferme::pluck('nom', 'id'))
                            ->searchable(),
                        TextInput::make('nom')
                            ->label("Nom de l'infrastructure")
                            ->rules([
                                function (\Filament\Forms\Get $get, $state) {
                                    return function (string $attribute, $value, Closure $fail) use ($get, $state){
                                        $nomFerme = Infrastructure::with('ferme')->whereFermeId($get('ferme_id'))->whereNom($state)->first();
                                        if (isset($nomFerme)) {
                                            $fail("Le {$attribute} $value est porté par une autre infrastructure de cette ferme.");
                                        }
                                    };
                                }
                            ]),
                        DatePicker::make('created_at')
                            ->required()
                            ->label('Date de construction'),
                        Select::make('type_infrastructure_id')
                            ->relationship(name: 'typeInfrastructure', titleAttribute: 'nom')
                            ->afterStateUpdated(fn(Forms\Set $set, $state) => $set('typeInfrastructure', TypeInfrastructure::find($state)))
                            ->live()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nom')
                                    ->required(),
                                Toggle::make('surface')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('circulaire')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('volume')
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                        TextInput::make('longueur')
                            ->hidden(fn(\Filament\Forms\Get $get) => $get('type_infrastructure_id') ? TypeInfrastructure::find($get('type_infrastructure_id'))->circulaire : true),
                       TextInput::make('largeur')
                            ->hidden(fn(\Filament\Forms\Get $get) => $get('type_infrastructure_id') ? TypeInfrastructure::find($get('type_infrastructure_id'))->circulaire : true),
                        TextInput::make('diametre')
                            ->hidden(fn(\Filament\Forms\Get $get) => $get('type_infrastructure_id') ? TypeInfrastructure::find($get('type_infrastructure_id'))->surface : true),
                        TextInput::make('profondeur')
                            ->hidden(fn(\Filament\Forms\Get $get) => !$get('type_infrastructure_id') || !TypeInfrastructure::find($get('type_infrastructure_id'))->volume),
                        TextInput::make('niveau')
                            ->hidden(fn(\Filament\Forms\Get $get) => !$get('type_infrastructure_id') || !TypeInfrastructure::find($get('type_infrastructure_id'))->volume)
                            ->suffix('%')
                            ->default(100),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ferme_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_infrastructure_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longueur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('largeur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diametre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('profondeur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('niveau')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('superficie')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume')
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
            'index' => Pages\ListInfrastructures::route('/'),
            'create' => Pages\CreateInfrastructure::route('/create'),
            'edit' => Pages\EditInfrastructure::route('/{record}/edit'),
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
