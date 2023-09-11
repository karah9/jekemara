<?php

namespace App\Filament\Pages;

use App\Models\Cycle;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class BilanFinancierCycle extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.bilan-financier-cycle';

    public $cycle_id;
    public $cycle;
    public $achatInitial;
    public $pdcs;
    public $pdcRemplacement;
    public $pdcRemplacementAchat;
    public $alimentations;
    public function mount(Request $request){
        $this->cycle_id = $request->cycle_id;
        $this->cycle = Cycle::whereId($this->cycle_id)->with( 'pdcs', 'traitements', 'depenses', 'recoltes')->first();
        $this->pdcs = $this->cycle->pdcs->where('type', 'pdc');
        $this->pdcRemplacement = $this->pdcs->sum('remplacement');
        $this->pdcRemplacementAchat = $this->pdcs->sum('achat');
        $this->alimentations = $this->cycle->alimentations->flatten(1)->groupBy('aliment_id');
        $this->achatInitial =  ($this->cycle->firstPdc->nombre + $this->cycle->firstPdc->remplacement)*$this->cycle->firstPdc->achat;

//        $this->prixVente =  round($this->cycle->recoltes->sum('montant') / $this->cycle->recoltes->sum('prixkg'), 0);

    }
}
