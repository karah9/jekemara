<?php

namespace App\Filament\Pages;

use App\Models\Cycle;
use Filament\Pages\Page;
use Illuminate\Http\Request;


class RapportTechniqueCycle extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rapport-technique-cycle';

    public $cycle_id;
    public $fermeId;
    public $cycle;
    public $firstPdc;
    public $lastPdc;
    public $alimentations;
    public function mount(Request $request){
        $this->cycle_id = $request->cycle_id;
        $this->cycle = Cycle::whereId($this->cycle_id)->with( 'pdcs', 'traitements', 'depenses', 'recoltes')->first();
        $this->firstPdc = $this->cycle->pdcs->first();
        $this->lastPdc = $this->cycle->pdcs->last();
        $this->alimentations = $this->cycle->alimentations->flatten(1)->groupBy('aliment_id');

    }

}
