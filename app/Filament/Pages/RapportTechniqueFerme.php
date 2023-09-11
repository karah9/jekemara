<?php

namespace App\Filament\Pages;

use App\Models\Cycle;
use App\Models\Ferme;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class RapportTechniqueFerme extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rapport-technique-ferme';

    public $ferme_id;
    public $cycles;
    public $infrastructures;
    public $firstPdc;
    public $lastPdc;
    public $alimentations;
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
                                    ->reactive()
                                    ->options([
                                        'tout' => 'Tout',
                                        'multiselect' => 'Multi Selection',
                                    ]),
                                Select::make('fermeIds')
                                    ->multiple()
                                    ->reactive()
                                    //->hidden(fn(Get $get) => $get('type') == 'tout' || is_null($this->type))
                                    ->label('Ferme')
                                    ->options(Ferme::all()->pluck('nom', 'id'))
                                    ->searchable(),
                            ]),

                        DatePicker::make('startDate')
                            ->label('Date de debut')
                            ->format('Y-m-d'),
                        DatePicker::make('endDate')
                            ->label('Date de fin')
                            ->format('Y-m-d'),
                    ])
                    ->columns(1)
        ]);
    }
}
