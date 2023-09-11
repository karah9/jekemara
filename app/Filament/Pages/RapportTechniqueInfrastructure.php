<?php

namespace App\Filament\Pages;

use App\Models\Cycle;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class RapportTechniqueInfrastructure extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rapport-technique-infrastructure';


    public $infrastructure_id;
    public $cycles;
    public $infrastructure;
    public $firstPdc;
    public $lastPdc;
    public $alimentations;
    public function mount(Request $request){
        $this->infrastructure_id = $request->infrastructure_id;
        $this->infrastructure = Cycle::whereId($this->infrastructure_id)
            ->with('cycles', 'pdcs', 'traitements', 'depenses', 'recoltes')
            ->withCount('cycles')
            ->first();

//        $this->firstPdc = $this->cycle->pdcs->first();
//        $this->lastPdc = $this->cycle->pdcs->last();
//        $this->alimentations = $this->cycle->alimentations->flatten(1)->groupBy('aliment_id');

    }
}
