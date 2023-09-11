<?php

namespace App\Filament\Pages;

use App\Models\Ferme;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;

class RapportTechniqueFermeForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rapport-technique-ferme-form';
    public $fermeIds = '';
    public $cycles = '';
    public $type = '';
    public $startDate = '';
    public $allDate = '';
    public $endDate = '';
    public function mount(){
//        $this->firstPdc = $this->cycle->pdcs->first();
//        $this->lastPdc = $this->cycle->pdcs->last();
//        $this->alimentations = $this->cycle->alimentations->flatten(1)->groupBy('aliment_id');

    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Rapport Technique de la ferme entre une date de début une date de fin')
                    ->schema([
                        Section::make('Sélection des fermes')
                            ->schema([
                                Radio::make('type')
                                    ->live()
                                    ->options([
                                        'tout' => 'Tout',
                                        'multiselect' => 'Multi Selection',
                                    ]),
                                Select::make('fermeIds')
                                    ->multiple()
                                    ->live()
                                    ->hidden(fn(Get $get) => $get('type') == 'tout' || is_null($get('type')))
                                    ->label('Ferme')
                                    ->options(Ferme::all()->pluck('nom', 'id')),
                            ]),

                        Section::make('Intervale du rapport')
                            ->schema([
                                Radio::make('allDate')
                                    ->label('Toutes les dates')
                                    ->options([
                                        'tout' => 'Tout'
                                    ]),
                                DatePicker::make('startDate')
                                    ->label('Date de debut')
                                    ->format('Y-m-d'),
                                DatePicker::make('endDate')
                                    ->label('Date de fin')
                                    ->format('Y-m-d'),

                                ])
                            ->columns(4)
                    ])
                    ->columns(1)
            ]);
    }

    public function submit(){
        if(is_array($this->fermeIds)){
            $fermeIdString = implode(',', $this->fermeIds);
        }else{
            $fermeIdString = 'tout';
        }
        if($this->allDate){
            $this->startDate = (new \DateTime('2000-01-01'))->format('Y-m-d');
            $this->endDate = (new \DateTime(now()))->format('Y-m-d');
        }
        $this->startDate = (new \DateTime($this->startDate))->format('Y-m-d');
        $this->endDate = (new \DateTime($this->endDate))->format('Y-m-d');

        $this->redirectRoute('filament.admin.pages.rapport-technique-ferme-view', ['fermeIds' => $fermeIdString,'startDate' => $this->startDate, 'endDate' => $this->endDate]);

//
//        $this->infrastructures = $this->cycleDetails->getInfrastructure()->toArray();
    }
}
