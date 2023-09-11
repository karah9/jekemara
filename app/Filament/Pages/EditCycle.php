<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CycleResource;
use App\Filament\Resources\CycleResource\RelationManagers\DepensesRelationManager;
use App\Filament\Resources\CycleResource\RelationManagers\TraitementsRelationManager;
use App\Models\Aliment;
use App\Models\Alimentation;
use App\Models\Cycle;
use App\Models\Espece;
use App\Models\Infrastructure;
use App\Models\Pdc;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Resources\Pages\PageRegistration;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;

class EditCycle extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-cycle';

    protected static bool $shouldRegisterNavigation = false;

    public $cycle;
    public $infrastructure_id = '';
    public $espece_id = '';
    public $created_at;
    public $nombre = '';
    public $achat = '';
    public $poids_moyen = '';
    public $mortalite = 0;
    public $remplacement = 0;
    public $ration = '';
    public $aliment_id  = '';
    public $quantite  = '';
    public $prix  = '';
    public $pdc;
    public ?array $data = [];
    public $alimentation;

    public function mount($record){
        $this->cycle = Cycle::with('pdcs', 'infrastructure')->where('id', $record)->first();
        $this->pdc = $this->cycle->pdcs->first();
        $this->alimentation = $this->cycle->pdcs->first()->alimentation;
        $this->form->fill([
            'infrastructure_id' => $this->cycle->infrastructure->id,
            'espece_id' => $this->cycle->espece_id,
            'nombre' => $this->pdc->nombre,
            'achat' => $this->pdc->achat,
            'poids_moyen' => $this->pdc->poids_moyen,
            'mortalite' => $this->pdc->mortalite,
            'remplacement' => $this->pdc->remplacement,
            'created_at' => $this->cycle->created_at,
            'ration' => $this->alimentation->ration,
            'aliment_id' => $this->alimentation->aliment_id,
            'quantite' => $this->alimentation->quantite,
            'prix' => $this->alimentation->prix,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Modification de la mise en charge')
                    ->description("Formulaire d'edition du nouveau cycle")
                    ->schema([
                        Select::make('infrastructure_id')
                            ->options(Infrastructure::pluck('nom', 'id'))
                            ->disabled()
                            ->label('Nom de l\'infrastructure')
                            ->required(),
                        Section::make('Les informations sur le cycle')
                            ->schema([
                                DatePicker::make('created_at')
                                    ->label('Date de la mise en charge')
                                    ->required(),
                                Select::make('espece_id')
                                    ->options(Espece::pluck('nom', 'id'))
                                    ->live(),
                                TextInput::make('nombre')
                                    ->disabled(fn(\Filament\Forms\Get $get) => empty($get('espece_id')))
                                    ->afterStateUpdated(function(\Filament\Forms\Get $get, \Filament\Forms\Set $set, $state){
                                        if(!empty($get('ration'))){
                                            $biomasse = ((int)$get('nombre') - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((int)$biomasse * (int)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
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
                                            $set('quantite', round((int)$biomasse * (int)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
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
                                            $set('quantite', round((int)$biomasse * (int)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
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
                                            $set('quantite', round((int)$biomasse * (int)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
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
                                            $set('quantite', round((int)$biomasse * (int)$state / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->minValue('0')
                                    ->maxValue('10')
                                    ->live()
                                    ->required(),
                                Select::make('aliment_id')
                                    ->options(Aliment::pluck('nom', 'id'))
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
            ])
            ->statePath('data');
    }
    public static function route(string $path): PageRegistration
    {
        return new PageRegistration(
            page: static::class,
            route: fn (Panel $panel): Route => RouteFacade::get($path, static::class)
                ->middleware(static::getRouteMiddleware($panel)),
        );
    }

    public static function getRelations(): array
    {
        return [
            TraitementsRelationManager::class,
            DepensesRelationManager::class
        ];
    }

    public function submit(){
        $this->form->getState();
        $data = $this->data;
        $this->cycle->update([
            'espece_id' => $data['espece_id'],
            'created_at' => $data['created_at'],
            'infrastructure_id' => $data['infrastructure_id']
        ]);
        $this->pdc->update([
            'nombre' => $data['nombre'],
            'achat' => $data['achat'],
            'type' => 'charge',
            'mortalite' => $data['mortalite'],
            'remplacement' => $data['remplacement'],
            'poids_moyen' => $data['poids_moyen'],
            'created_at' => $data['created_at'],
            'cycle_id' => $this->cycle->id
        ]);
        $this->alimentation->update([
            "aliment_id" => $data['aliment_id'],
            "quantite" => round(($data['nombre'] - $data['mortalite'] + $data['remplacement'])*$data['poids_moyen']/1000 * $data['ration'] / 100, 2, PHP_ROUND_HALF_UP),
            "prix" => $data['prix'],
            "ration" => $data['ration'],
            "created_at" => $data['created_at'],
            "pdc_id" => $this->pdc->id
        ]);
        Notification::make()
            ->title('Enregistrer avec succes')
            ->success()
            ->seconds(20)
            ->send();
        $this->redirect('/admin');
    }

}
