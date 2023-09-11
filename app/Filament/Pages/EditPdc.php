<?php

namespace App\Filament\Pages;

use App\Models\Aliment;
use App\Models\Alimentation;
use App\Models\Cycle;
use App\Models\Infrastructure;
use App\Models\Pdc;
use Closure;
use DateTime;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Resources\Pages\PageRegistration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;

class EditPdc extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-pdc';

    protected static bool $shouldRegisterNavigation = false;


    public $cycle_id = '';
    public $echant = '';
    public $nombre = '';
    public $mortalite = '';
    public $remplacement = '';
    public $achat = '';
    public $poids_total = '';
    public $poids_moyen = '';
    public $prise_poids = '';
    public $created_at;
    public $ration = '';
    public $aliment_id = '';
    public $quantite = '';
    public $prix = '';
    public $cycle;
    public $alimentation;
    public $previousAlimentation;
    public $previousPdc;
    public $lastPdc;
    public $pdc;
    public ?array $data = [];
    public function mount($record){
        $this->pdc = Pdc::find($record);
        $this->cycle = $this->pdc->cycle;

        $this->lastPdc = $this->cycle->pdcs()->withoutGlobalScopes()->latest('id')->skip(1)->first();

        $this->alimentation = $this->pdc->alimentation;

        $this->previousAlimentation = $this->lastPdc->alimentation;
        $this->form->fill([
            'cycle_id' => $this->cycle->id,
            'created_at' => $this->pdc->created_at,
            'echant' => $this->pdc->echant,
            'nombre' => $this->pdc->nombre,
            'poids_total' => $this->pdc->poids_total,
            'achat' => $this->pdc->achat,
            'poids_moyen' => $this->pdc->poids_moyen,
            'prise_poids' => $this->pdc->prise_poids,
            'mortalite' => $this->pdc->mortalite,
            'remplacement' => $this->pdc->remplacement,
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
                Section::make('Formulaire d\'édition de la pêche de contrôle')
                    ->schema([
                        TextInput::make('cycle_id')
                            ->formatStateUsing(fn (string $state): string => $this->cycle->nom)
                            ->disabled()
                            ->label('Nom du cycle')
                            ->required(),
                        Section::make('Les informations sur la pêche')
                            ->schema([
                                DatePicker::make('created_at')
                                    ->label('Date de la pêche de controle')
                                    ->rules([
                                        function (Get $get) {
                                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                                $minDate = date_add(clone $this->lastPdc->created_at, date_interval_create_from_date_string('15 days'));
                                                if (new DateTime($value) < $minDate) {
                                                    $fail("La date doit être au moins 15 jours après la dernière PDC.");
                                                }
                                            };
                                        },
                                    ])
                                    ->helperText(function (Get $get){
                                        if ($this->cycle){
                                            if($this->lastPdc->type == 'charge'){
                                                return "La date de la mise en charge {$this->lastPdc->created_at->format('d-m-Y')}";
                                            }
                                            else{
                                                return  "La date de la derniere PDC: {$this->lastPdc->created_at->format('d-m-Y')}";
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
                                    ->numeric()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ($this->lastPdc->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
                                        }
                                    })
                                    ->label('Mortalité'),
                                TextInput::make('remplacement')
                                    ->live()
                                    ->numeric()
                                    ->afterStateUpdated(function (\Filament\Forms\Get $get, \Filament\Forms\Set $set, ?string $state) {
                                        if(!empty($get('ration'))){
                                            $biomasse = ($this->lastPdc->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
                                            $set('quantite', round((float)$biomasse * (float)$get('ration') / 100, 2, PHP_ROUND_HALF_UP));
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
                                            $biomasse = ($this->lastPdc->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
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
                                                if ($this->lastPdc->poids_moyen > $state) {
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
                                            $biomasse = ($this->lastPdc->nombre - (int)$get('mortalite') + (int)$get('remplacement'))*(int)$get('poids_moyen')/1000;
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
            ])
            ->model($this->cycle)
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

    public function submit(){
        $this->form->getState();
        $data = $this->data;
        $pdc = $this->pdc->update([
            'echant' => $data['echant'],
            'nombre' => $this->lastPdc->nombre - $data['mortalite'] + $data['remplacement'],
            'achat' => $data['achat'] ?? 0,
            'mortalite' => $data['mortalite'],
            'remplacement' => $data['remplacement'],
            'poids_moyen' => $data['poids_moyen'],
            'prise_poids' => $data['poids_moyen'] - $this->lastPdc->poids_moyen,
            'created_at' => $data['created_at'],
            'cycle_id' => $this->cycle->id
        ]);
        $this->previousAlimentation->update([
            'jour' => date_diff($this->previousAlimentation->created_at, new \DateTime($data['created_at']))->format('%R%a'),
        ]);
        $this->alimentation->update([
            "aliment_id" => $data['aliment_id'],
            "quantite" => $data['quantite'],
            "prix" => $data['prix'],
            "ration" => $data['ration'],
            "created_at" => $data['created_at'],
        ]);
        if ($data['ration'] == 0){

            $this->cycle->update([
                'end_at' => $data['created_at']
            ]);
            Notification::make()
                ->title('Vous avez Mis fin au cycle')
                ->success()
                ->send();
        }


        Notification::make()
            ->title('PDC modifié avec succes')
            ->success()
            ->send();

    }

}
